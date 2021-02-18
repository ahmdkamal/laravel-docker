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

    public function testGetAllProviders()
    {
        $request = new Request();
        $response = $this->userService->getAllUsers($request);
        $this->assertCount(5, $response);
    }

    public function testFilterByProviderX()
    {
        $request = new Request(['provider' => 'DataProviderX']);
        $response = $this->userService->getAllUsers($request);
        $this->assertCount(3, $response);
    }

    public function testFilterByProviderY()
    {
        $request = new Request(['provider' => 'DataProviderY']);
        $response = $this->userService->getAllUsers($request);
        $this->assertCount(2, $response);
    }

    public function testFilterByRefundedStatusCode()
    {
        $request = new Request(['statusCode' => 'refunded']);
        $response = $this->userService->getAllUsers($request);
        $this->assertCount(1, $response);
    }

    public function testFilterByDeclineStatusCode()
    {
        $request = new Request(['statusCode' => 'decline']);
        $response = $this->userService->getAllUsers($request);
        $this->assertCount(2, $response);
    }

    public function testFilterByAuthorizedStatusCode()
    {
        $request = new Request(['statusCode' => 'authorised']);
        $response = $this->userService->getAllUsers($request);
        $this->assertCount(2, $response);
    }

    public function testFilterByMinBalance()
    {
        $request = new Request(['balanceMin' => 1000]);
        $response = $this->userService->getAllUsers($request);
        $this->assertCount(2, $response);
    }

    public function testFilterByMaxBalance()
    {
        $request = new Request(['balanceMax' => 100]);
        $response = $this->userService->getAllUsers($request);
        $this->assertCount(1, $response);
    }

    public function testFilterByCurrency()
    {
        $request = new Request(['currency' => 'AED']);
        $response = $this->userService->getAllUsers($request);
        $this->assertCount(1, $response);
    }

    public function testFilterByAllFilters()
    {
        $request = new Request([
            'currency' => 'USD',
            'provider' => 'DataProviderX',
            'statusCode' => 'decline',
            'balanceMin' => 0,
            'balanceMax' => 100
        ]);
        $response = $this->userService->getAllUsers($request);
        $this->assertCount(1, $response);
    }
}
