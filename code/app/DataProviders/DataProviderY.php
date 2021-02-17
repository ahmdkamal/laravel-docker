<?php

namespace App\DataProviders;

use JsonStreamingParser\Listener\SimpleObjectQueueListener;
use JsonStreamingParser\Parser;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;

class DataProviderY extends DataProviderAbstract
{
    public function __construct()
    {
        $this->providerPath = storage_path('app/providers/DataProviderY.json');
        $this->statusCodes = [
            'authorised' => 100,
            'decline' => 200,
            'refunded' => 300,
            100 => 'authorised',
            200 => 'decline',
            300 => 'refunded',
        ];
    }

    public function search(array $filters = []): array
    {
        $listener = new SimpleObjectQueueListener(function ($user) use ($filters): void {
            if ($this->applyFilters($user, $filters)) {
                $this->users[] = $this->dataReturned($user);
            }
        }, 2);

        $parser = new Parser(fopen($this->providerPath, 'r'), $listener);
        $parser->parse();

        return $this->users;
    }

    protected function applyFilters(object $user, $filters = []): bool
    {
        if (Arr::has($filters, 'balanceMin') && $user->balance < Arr::get($filters, 'balanceMin')) {
            return false;
        }

        if (Arr::has($filters, 'balanceMax') && $user->balance > Arr::get($filters, 'balanceMax')) {
            return false;
        }

        if (Arr::has($filters, 'currency') && $user->currency !== Arr::get($filters, 'currency')) {
            return false;
        }

        if (Arr::has($filters, 'statusCode')
            && (!in_array(Arr::get($filters, 'statusCode'), $this->statusCodes)
                || $user->status !== $this->statusCodes[Arr::get($filters, 'statusCode')])
        ) {
            return false;
        }

        return true;
    }

    protected function dataReturned(object $user): array
    {
        return [
            'balance' => $user->balance,
            'currency' => $user->currency,
            'email' => $user->email,
            'status' => $this->statusCodes[$user->status],
            'created_at' => $user->created_at,
            'id' => $user->id
        ];
    }
}
