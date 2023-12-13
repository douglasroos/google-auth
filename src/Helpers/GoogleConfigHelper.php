<?php

namespace Bagisto\GoogleAuth\Helpers;

class GoogleConfigHelper
{
    public static function isConfigured()
    {
        $client_id = config('services.google.client_id');
        $client_secret = config('services.google.client_secret');
        $redirect = config('services.google.redirect');
        $tenant = config('services.google.tenant');

        return !empty($client_id) && !empty($client_secret) && !empty($redirect) && !empty($tenant);
    }
}
