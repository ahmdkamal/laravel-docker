<?php

namespace App\Services;

use App\DataProviders\DataProviderX;
use App\DataProviders\DataProviderY;
use \Illuminate\Http\Request;

class UserService
{
    const PROVIDERS = [
        'DataProviderX' => DataProviderX::class,
        'DataProviderY' => DataProviderY::class,
    ];

    public function getAllUsers(Request $request)
    {
        $users = [];
        $filters = $request->all();

        if ($request->provider !== null) {
            $provider = new (self::PROVIDERS[$request->provider]);
            $users = $provider->search($filters);
        } else {
            foreach (self::PROVIDERS as $PROVIDER) {
                $provider = new ($PROVIDER);
                $users = array_merge($users, $provider->search($filters));
            }
        }

        return $users;
    }
}
