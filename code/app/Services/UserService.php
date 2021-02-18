<?php

namespace App\Services;

use App\DataProviders\DataProviderX;
use App\DataProviders\DataProviderY;
use \Illuminate\Http\Request;

class UserService
{
    protected $providers = [
        'DataProviderX' => DataProviderX::class,
        'DataProviderY' => DataProviderY::class,
    ];

    public function getAllUsers(Request $request)
    {
        $users = [];
        $filters = $request->all();

        if ($request->provider !== null) {
            $provider = new ($this->providers[$request->provider]);
            $users = $provider->search($filters);
        } else {
            foreach ($this->providers as $provider) {
                $provider = new ($provider);
                $users = array_merge($users, $provider->search($filters));
            }
        }

        return $users;
    }
}
