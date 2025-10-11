<?php

namespace App\Services;

use App\Enums\StatusEnum;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RecaptchaService
{
    private const VERIFY_URL = 'https://www.google.com/recaptcha/api/siteverify';

    public function isActive(): bool
    {
        return SettingService::get('integration', 'recaptcha_status', StatusEnum::Passive->value) === StatusEnum::Active->value;
    }

    public function validation(Request|array $request): bool
    {
        if (! $this->isActive()) {
            return true;
        }

        $token = is_array($request) ? $request['g-recaptcha-response'] ?? null : $request->{'g-recaptcha-response'};

        if (empty($token)) {
            return false;
        }

        $secretKey = SettingService::get('integration', 'recaptcha_secret_key');
        if (! $secretKey) {
            return false;
        }
        try {
            $response = Http::timeout(10)->asForm()->post(self::VERIFY_URL, [
                'secret' => $secretKey,
                'response' => $token,
                'remoteip' => request()->ip(),
            ]);

            if (! $response->successful()) {
                return false;
            }

            $data = $response->json();
            $minScore = SettingService::get('integration', 'recaptcha_min_score', 0.5);

            return $data['success'] && $data['score'] >= $minScore;
        } catch (Exception) {
            return false;
        }
    }

    public function getSiteKey(): ?string
    {
        return $this->isActive()
            ? SettingService::get('integration', 'recaptcha_site_key')
            : null;
    }

    public function getConfig(): array
    {
        return [
            'isActive' => $this->isActive(),
            'site_key' => $this->getSiteKey(),
        ];
    }
}
