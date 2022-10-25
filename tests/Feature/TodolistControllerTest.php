<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    public function testTodolist()
    {
        $this->session([
            'user' => 'eko',
            'todolist' => [
                [
                    'id'    => '1',
                    'todo'  => 'eko'
                ]
            ]
        ])->get('/todolist')
            ->assertSeeText('1')
            ->assertSeeText('eko');
    }

    public function testSaveTodoError()
    {
        $this->session([
            'user'  => 'eko'
        ])->post('/todolist/save', [])
            ->assertSeeText('todo is required');
    }

    public function testSaveTodoSuccess()
    {
        $this->session([
            'user'  => 'eko'
        ])->post('/todolist/save', [
            'todo' => 'eko'
        ])->assertRedirect('/todolist');
    }

    public function testTodolistRemove()
    {
        $this->session([
            'user' => 'eko',
            'todolist' => [
                [
                    'id'    => '1',
                    'todo'  => 'eko'
                ]
            ]
        ])->post('/todolist/1/remove')
            ->assertRedirect('/todolist');
    }

}
