<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Submission;
use Illuminate\Support\Facades\Redis;
use Log;
use Config;

class AddInfusionsoftCompletionTag implements ShouldQueue
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
            $this->applyTag($infusionsoft);
        } catch (\Infusionsoft\TokenExpiredException $e) {
            // Refresh our access token since we've thrown a token expired exception
            $infusionsoft->refreshAccessToken();

            // We also have to save the new token, since it's now been refreshed.
            // We serialize the token to ensure the entire PHP object is saved
            // and not accidentally converted to a string
            Redis::set('infusionsoft_token', serialize($infusionsoft->getToken()));

            $this->applyTag($infusionsoft);
        }
    }

    private function applyTag($infusionsoft)
    {
        if ($this->submission->user->contact_id) {
            $contact_id = $this->submission->user->contact_id;
            $contact = $infusionsoft->contacts()->find($contact_id);

            //add tag for contact
            if ($this->submission->reason == "Bankruptcy")
                $contact->addTags([Config::get('field_values.infusionsoft.tag_bankruptcy_track_completion')]);
            else
                $contact->addTags([Config::get('field_values.infusionsoft.tag_general_track_completion')]);
        }
    }
}
