<?php

namespace Bagisto\GoogleAuth\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

use function Laravel\Prompts\text;
use function Laravel\Prompts\info;
use function Laravel\Prompts\confirm;

class ConfigureGoogle extends Command
{
    protected $signature = 'google:configure';
    protected $description = 'Configure Google environment variables';

    public function handle()
    {
        info('Welcome to the Google Account SSO configuration wizard');

        if ($this->keysExist()) {
            $overwrite = confirm('Google configuration keys already exist. This wizard will overwrite existing settings. Continue?', false);

            if (!$overwrite) {
                return;
            }
        }

        $clientId = text(
            label: 'Please enter your client ID',
            required: true
        );

        $this->updateEnvFile('GOOGLE_CLIENT_ID', $clientId);

        $clientSecret = text(
            label: 'Please enter your client Secret',
            required: true
        );

        $this->updateEnvFile('GOOGLE_CLIENT_SECRET', $clientSecret);

        $this->updateEnvFile('GOOGLE_REDIRECT_URL', route('google.callback'));

        $authorizedDomain = text(
            label: 'Please enter your authorized domain  ie (example.com)',
            required: true
        );

        $this->updateEnvFile('GOOGLE_AUTHORIZED_DOMAIN', $authorizedDomain);

        Artisan::call('optimize');
        
        Artisan::call('vendor:publish', [
            '--provider' => "Bagisto\GoogleAuth\Providers\GoogleAuthServiceProvider",
            '--force'    => true
        ]);

        info('Google Account SSO configuration completed successfully.');
    }

    protected function keysExist()
    {
        return env('GOOGLE_CLIENT_ID') !== null
            && env('GOOGLE_CLIENT_SECRET') !== null
            && env('GOOGLE_AUTHORIZED_DOMAIN') !== null;
    }

    protected function updateEnvFile($key, $value)
    {
        $envFilePath = base_path('.env');

        if (File::exists($envFilePath)) {
            $envContent = File::get($envFilePath);

            if (Str::contains($envContent, "{$key}=")) {
                $envContent = preg_replace("/{$key}=.*/", "{$key}=\"{$value}\"", $envContent);
            } else {
                $envContent .= PHP_EOL . "{$key}=\"{$value}\"";
            }

            File::put($envFilePath, $envContent);
        }
    }
}
