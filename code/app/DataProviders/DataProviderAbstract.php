<?php

namespace App\DataProviders;

abstract class DataProviderAbstract
{
    protected $providerPath;

    protected $users = [];

    protected $statusCodes = [];

    public abstract function search(array $filters = []): array;

    protected abstract function applyFilters(object $user, $filters = []): bool;

    protected abstract function dataReturned(object $user): array;
}
