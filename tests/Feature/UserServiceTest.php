<?php

namespace Tests\Feature;

use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private UserService $userService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userService = $this->app->make(UserService::class);
    }

    public function testLoginUserSuccess()
    {
        self::assertTrue($this->userService->login('eko','rahasia'));
    }

    public function testLoginUserNotFound()
    {
        self::assertFalse($this->userService->login('siapa','siapa'));
    }

    public function testLoginWrongPassword()
    {
        self::assertFalse($this->userService->login('eko','bukanrahasia'));
    }

}
