<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SmsApiService
{
    public function send(string $to, string $message): array
    {
        $token = (string) config('services.smsapi.oauth_token');
        $baseUrl = rtrim((string) config('services.smsapi.base_url', 'https://api.smsapi.pl'), '/');
        $from = (string) config('services.smsapi.sender');

        if ($token === '') {
            throw new \RuntimeException('SMSAPI OAuth token is not configured.');
        }

        if ($from === '') {
            throw new \RuntimeException('SMSAPI sender is not configured.');
        }

        $response = Http::retry(3, 300)
            ->withToken($token)
            ->asForm()
            ->post($baseUrl . '/sms.do', [
                'to' => $to,
                'message' => $message,
                'from' => $from,
                'format' => 'json',
            ]);

        if ($response->failed()) {
            throw new \RuntimeException('SMSAPI request failed: ' . $response->status() . ' ' . $response->body());
        }

        $payload = $response->json();
        if (is_array($payload) && isset($payload['error'])) {
            $code = $payload['error'];
            $msg = $payload['message'] ?? 'Unknown SMSAPI error';
            throw new \RuntimeException("SMSAPI error {$code}: {$msg}");
        }

        $firstMessage = is_array($payload) && isset($payload['list'][0]) ? $payload['list'][0] : [];
        if (!isset($firstMessage['id'])) {
            throw new \RuntimeException('SMSAPI response does not contain message id.');
        }

        return [
            'provider_message_id' => $firstMessage['id'],
            'raw' => $payload,
        ];
    }
}
