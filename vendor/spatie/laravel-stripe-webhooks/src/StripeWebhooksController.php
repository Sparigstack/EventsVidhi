<?php

namespace Spatie\StripeWebhooks;

use Illuminate\Http\Request;
use Spatie\WebhookClient\Models\WebhookCall;
use Spatie\WebhookClient\WebhookConfig;
use Spatie\WebhookClient\WebhookProcessor;
use Spatie\WebhookClient\WebhookProfile\ProcessEverythingWebhookProfile;
use App\DemoTable;

class StripeWebhooksController
{
    public function __invoke(Request $request, string $configKey = null)
    {
        $webhookConfig = new WebhookConfig([
            'name' => 'stripe',
            'signing_secret' => ($configKey) ?
                config('stripe-webhooks.signing_secret_'.$configKey) :
                config('stripe-webhooks.signing_secret'),
            'signature_header_name' => 'Stripe-Signature',
            'signature_validator' => StripeSignatureValidator::class,
            'webhook_profile' => ProcessEverythingWebhookProfile::class,
            'webhook_model' => WebhookCall::class,
            'process_webhook_job' => config('stripe-webhooks.model'),
        ]);

        $webhookRequest = $request;
        // $demoTable = new DemoTable();
        // $demoTable->name = $webhookRequest['data']['object']['lines']['data'][0]['subscription'];
        // $demoTable->role = $webhookRequest['data']['object']['lines']['data'][0]['price']['recurring']['interval'];
        // $demoTable->save();

        updateRecurringSubscription($webhookRequest);
        $eventPayload = $request->input();

        (new WebhookProcessor($request, $webhookConfig))->process();

        return response()->json(['message' => 'ok']);
    }
}
