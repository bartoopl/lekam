<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'smsapi' => [
        'oauth_token' => env('SMSAPI_OAUTH_TOKEN'),
        'base_url' => env('SMSAPI_BASE_URL', 'https://api.smsapi.pl'),
        'sender' => env('SMSAPI_SENDER'),
        'enabled' => env('SMSAPI_ENABLED', false),
        'quiet_hours_start' => env('SMSAPI_QUIET_HOURS_START', '20:00'),
        'quiet_hours_end' => env('SMSAPI_QUIET_HOURS_END', '08:00'),
        'daily_limit' => (int) env('SMSAPI_DAILY_LIMIT', 1000),
        'scenario_run_limit' => (int) env('SMSAPI_SCENARIO_RUN_LIMIT', 200),
        'per_user_cooldown_hours' => (int) env('SMSAPI_PER_USER_COOLDOWN_HOURS', 24),
    ],

];
