<?php

namespace App\Http\Controllers;

use Request;
use Illuminate\Support\Facades\Redis;
use Log;
use App\Jobs\UpdateInfusionsoftContact;
use App\Jobs\AddInfusionsoftCompletionTag;
use App\Submission;

class InfusionsoftController extends Controller
{
    public function login()
    {
        // Setup a new Infusionsoft SDK object
        $infusionsoft = new \Infusionsoft\Infusionsoft(array(
            'clientId'     => getenv('INFUSIONSOFT_CLIENT_ID'),
            'clientSecret' => getenv('INFUSIONSOFT_CLIENT_SECRET'),
            'redirectUri'  => getenv('INFUSIONSOFT_REDIRECT_URL'),
        ));

        echo '<a href="' . $infusionsoft->getAuthorizationUrl() . '">Click here to connect to Infusionsoft';
    }

    public function callback()
    {
        // Setup a new Infusionsoft SDK object
        $infusionsoft = new \Infusionsoft\Infusionsoft(array(
            'clientId'     => getenv('INFUSIONSOFT_CLIENT_ID'),
            'clientSecret' => getenv('INFUSIONSOFT_CLIENT_SECRET'),
            'redirectUri'  => getenv('INFUSIONSOFT_REDIRECT_URL'),
        ));

        // If the serialized token is already available in the session storage,
        // we tell the SDK to use that token for subsequent requests, rather
        // than try and retrieve another one.
        //$test = Redis::get('test');
        $token = Redis::get('infusionsoft_token');
        if ($token) {
            $infusionsoft->setToken(unserialize($token));
        }

        // If we are returning from Infusionsoft we need to exchange the code
        // for an access token.
        if (Request::has('code') and !$infusionsoft->getToken()) {
            $infusionsoft->requestAccessToken(Request::get('code'));
        }

        // NOTE: there's some magic in the step above - the Infusionsoft SDK has
        // not only requested an access token, but also set the token in the current
        // Infusionsoft object, so there's no need for you to do it.
        if ($infusionsoft->getToken()) {
            // Save the serialized token to the current session for subsequent requests
            // NOTE: this can be saved in your database - make sure to serialize the
            // entire token for easy future access
            Redis::set('infusionsoft_token', serialize($infusionsoft->getToken()));

            // Now redirect the user to a page that performs some Infusionsoft actions
            return redirect()->to('/');
        }

        // something didn't work, so let's go back to the beginning
        return redirect()->to('/');
    }
}
