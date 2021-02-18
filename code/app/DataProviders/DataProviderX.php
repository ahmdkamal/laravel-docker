<?php

namespace App\DataProviders;

use JsonStreamingParser\Listener\GeoJsonListener;
use JsonStreamingParser\Parser;
use Illuminate\Support\Arr;

class DataProviderX extends DataProviderAbstract
{
    public function __construct()
    {
        $this->providerPath = storage_path('app/providers/DataProviderX.json');
        $this->statusCodes = [
            'authorised' => 1,
            'decline' => 2,
            'refunded' => 3,
            1 => 'authorised',
            2 => 'decline',
            3 => 'refunded',
        ];
    }

    public function search(array $filters = []): array
    {
        $listener = new GeoJsonListener(function ($user) use($filters) : void {
            $user = (object)$user;
            if ($this->applyFilters($user, $filters)) {
                $this->users[] = $this->dataReturned($user);
            }
        });

        $fp = fopen($this->providerPath, 'r');
        $parser = new Parser($fp, $listener);
        $parser->parse();
        fclose($fp);

        return $this->users;
    }

    protected function applyFilters(object $user, $filters = []): bool
    {
        if (Arr::has($filters, 'balanceMin') && $user->parentAmount < Arr::get($filters, 'balanceMin')) {
            return false;
        }

        if (Arr::has($filters, 'balanceMax') && $user->parentAmount > Arr::get($filters, 'balanceMax')) {
            return false;
        }

        if (Arr::has($filters, 'currency') && $user->Currency !== Arr::get($filters, 'currency')) {
            return false;
        }

        if (Arr::has($filters, 'statusCode')
            && (!in_array(Arr::get($filters, 'statusCode'), $this->statusCodes)
                || $user->statusCode !== $this->statusCodes[Arr::get($filters, 'statusCode')])
        ) {
            return false;
        }

        return true;
    }

    protected function dataReturned(object $user): array
    {
        return [
            'balance' => $user->parentAmount,
            'currency' => $user->Currency,
            'email' => $user->parentEmail,
            'status' => $this->statusCodes[$user->statusCode],
            'created_at' => $user->registerationDate,
            'id' => $user->parentIdentification
        ];
    }
}
