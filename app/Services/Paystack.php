<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class Paystack
{
    public function isConfigured(): bool
    {
        return filled(config('services.paystack.secret_key'));
    }

    /**
     * Start a transaction and return the URL to redirect the customer to.
     *
     * @param  int  $amountKobo  Amount in kobo (i.e. Naira amount * 100).
     */
    public function initialize(string $reference, int $amountKobo, string $email, string $callbackUrl, array $metadata = []): string
    {
        $response = Http::withToken(config('services.paystack.secret_key'))
            ->baseUrl(config('services.paystack.base_url'))
            ->post('/transaction/initialize', [
                'reference' => $reference,
                'amount' => $amountKobo,
                'email' => $email,
                'callback_url' => $callbackUrl,
                'metadata' => $metadata,
            ]);

        if (! $response->successful() || ! $response->json('status')) {
            throw new RuntimeException('Could not start Paystack transaction: '.$response->json('message', 'unknown error'));
        }

        return $response->json('data.authorization_url');
    }

    /**
     * Verify a transaction with Paystack. Returns the decoded "data" payload.
     */
    public function verify(string $reference): array
    {
        $response = Http::withToken(config('services.paystack.secret_key'))
            ->baseUrl(config('services.paystack.base_url'))
            ->get("/transaction/verify/{$reference}");

        if (! $response->successful()) {
            throw new RuntimeException('Could not verify Paystack transaction: '.$response->json('message', 'unknown error'));
        }

        return $response->json('data', []);
    }
}
