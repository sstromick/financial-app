<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Submission;
use Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Config;


class UpdateInfusionsoftContact implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $submission;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Submission $submission)
    {
        $this->submission = $submission;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Setup a new Infusionsoft SDK object
        $infusionsoft = new \Infusionsoft\Infusionsoft(array(
            'clientId'     => getenv('INFUSIONSOFT_CLIENT_ID'),
            'clientSecret' => getenv('INFUSIONSOFT_CLIENT_SECRET'),
            'redirectUri'  => getenv('INFUSIONSOFT_REDIRECT_URL'),
        ));

        // Set the token if we have it in storage (in this case, a session)
        $infusionsoft->setToken(unserialize(Redis::get('infusionsoft_token')));

        try {
            $this->updateAndTagClient($infusionsoft);
        } catch (\Infusionsoft\TokenExpiredException $e) {
            // Refresh our access token since we've thrown a token expired exception
            $infusionsoft->refreshAccessToken();

            // We also have to save the new token, since it's now been refreshed.
            // We serialize the token to ensure the entire PHP object is saved
            // and not accidentally converted to a string
            Redis::set('infusionsoft_token', serialize($infusionsoft->getToken()));

            $this->updateAndTagClient($infusionsoft);
        }
    }

    private function updateAndTagClient($infusionsoft)
    {
        $contact = $infusionsoft->contacts()->where('email', $this->submission->user->email)->get();

        if (count($contact) == 0) {
            $contact = $infusionsoft->contacts()->create([
                'email_addresses' => [
                    [
                        'email' => $this->submission->user->email,
                        'field' => "EMAIL1"
                    ]
                ],
                'given_name' => $this->submission->first_name,
                'family_name' => $this->submission->last_name,
                'opt_in_reason' => "opted-in through IRIS Application"
            ]);
        } else {
            $contact = $contact[0];
        }

        //add tag for contact
        if ($this->submission->reason == "Bankruptcy")
            $contact->addTags([Config::get('field_values.infusionsoft.tag_bankruptcy_track')]);
        else
            $contact->addTags([Config::get('field_values.infusionsoft.tag_general_track')]);

        if (Str::contains($this->submission->referrer, Config::get('field_values.infusionsoft.referrer_advantageccs.url_snippet')))
            $contact->addTags([Config::get('field_values.infusionsoft.referrer_advantageccs.tag')]);

        if ($this->submission->referrer_tag_id)
            $contact->addTags(array($this->submission->referrer_tag_id));

        $this->submission->user->contact_id = $contact->id;
        $this->submission->user->save();
    }
}
