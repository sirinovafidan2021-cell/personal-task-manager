<?php

namespace App\Ship\Commands;

use App\Ship\Parents\Commands\Command;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Client;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Passport;
use RuntimeException;

final class ConfigureTaskManagerPassport extends Command
{
    protected $signature = 'task-manager:passport-client';
    protected $description = 'Create the local Password Grant client and save its credentials in .env without printing the secret.';

    public function handle(ClientRepository $clients): int
    {
        $configuredId = config('appSection-authentication.clients.web.id');
        if ($configuredId && Client::query()->whereKey($configuredId)->where('revoked', false)->exists()) {
            $this->warn('Aktiv Password Grant client artıq konfiqurasiya edilib. Heç nə dəyişdirilmədi.');

            return self::SUCCESS;
        }

        if (!is_file(Passport::keyPath('oauth-private.key')) || !is_file(Passport::keyPath('oauth-public.key'))) {
            Artisan::call('passport:keys');
        }

        $client = $clients->createPasswordGrantClient('Personal Task Manager Web', 'users', true);
        if (!$client->plainSecret) {
            throw new RuntimeException('Password Grant client secret yaradıla bilmədi.');
        }

        $this->putEnvValue('CLIENT_WEB_ID', (string) $client->getKey());
        $this->putEnvValue('CLIENT_WEB_SECRET', $client->plainSecret);
        $this->info('Password Grant client yaradıldı və lokal .env konfiqurasiyasına təhlükəsiz yazıldı. Secret ekranda göstərilmir.');

        return self::SUCCESS;
    }

    private function putEnvValue(string $key, string $value): void
    {
        $path = app()->environmentFilePath();
        $contents = is_file($path) ? file_get_contents($path) : '';
        if ($contents === false) {
            throw new RuntimeException('.env faylı oxuna bilmədi.');
        }

        $line = $key . '=' . $value;
        $pattern = '/^' . preg_quote($key, '/') . '=.*$/m';
        $contents = preg_match($pattern, $contents) ? preg_replace($pattern, $line, $contents) : rtrim($contents) . PHP_EOL . $line . PHP_EOL;
        if (file_put_contents($path, $contents) === false) {
            throw new RuntimeException('.env faylı yenilənə bilmədi.');
        }
    }
}
