<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testLogin()
    {
        $this->get('/login')
            ->assertSeeText('Login');
    }

    public function testLoginPageForMember()
    {
        $this->withSession([
            'user'=>'eko'
        ])->get('/login')
            ->assertRedirect('/');
    }

    public function testLoginUserSuccess()
    {
        $this->post('/login', [
            'user' => 'eko',
            'password' => 'rahasia'
        ])->assertRedirect('/')
            ->assertSessionHas('user','eko');
    }

    public function testLoginUserAlreadyLogin()
    {
        $this->withSession([
            'user'=> 'eko'
        ])->post('/login', [
            'user' => 'eko',
            'password' => 'rahasia'
        ])->assertRedirect('/');
    }

    public function testLoginValidationError()
    {
        $this->post('/login', [])->assertSeeText('User or Password is required');
    }

    public function testLoginWrong()
    {
        $this->post('/login', [
            'user' => 'wrong',
            'password' => 'wrong'
        ])->assertSeeText('User or Password is wrong');
    }

    public function testLogout()
    {
        $this->withSession([
            'user' => 'eko'
        ])->post('/logout')
            ->assertRedirect('/')->assertSessionMissing('user');
    }

    public function testLogoutForGuest()
    {
        $this->post('/logout')
            ->assertRedirect('/');
    }
}
