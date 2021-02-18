<?php

namespace Tests\Unit;

use App\DataProviders\DataProviderXTest;
use App\DataProviders\DataProviderYTest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Tests\TestCase;

class UserTest extends TestCase
{
    protected $userService;
    public function setUp(): void
    {
        parent::setUp();
        $this->userService = new UserService();
        $userService = new \ReflectionClass($this->userService);
        $providedTests = $userService->getProperty('providers');
        $providedTests->setAccessible(true);
        $providedTests->setValue($this->userService, [
            'DataProviderX' => DataProviderXTest::class,
            'DataProviderY' => DataProviderYTest::class,
        ]);
    }

    public function testGetAllProviderX()
    {
        $request = new Request();
        $response = $this->userService->getAllUsers($request);
        dd($response);
        $this->assertCount(4, $response);
    }
}
