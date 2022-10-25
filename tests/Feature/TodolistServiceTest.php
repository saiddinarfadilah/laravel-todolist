<?php

namespace Tests\Feature;

use App\Services\TodolistService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class TodolistServiceTest extends TestCase
{
    private TodolistService $todolistService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->todolistService = $this->app->make(TodolistService::class);
    }

    public function testTodolistNotNull()
    {
        self::assertNotNull($this->todolistService);
    }

    public function testSaveTodo()
    {
        $this->todolistService->saveTodo('1','eko');
        $todolist = Session::get('todolist');
        foreach ($todolist as $value){
            self::assertEquals('1', $value['id']);
            self::assertEquals('eko', $value['todo']);
        }
    }

    public function testGetTodolistEmpty()
    {
        self::assertEquals([], $this->todolistService->getTodo());
    }

    public function testGetTodolistNotEmpty()
    {
        $todolist = [
            [
               'id'     => '1',
               'todo'   => 'eko'
            ],
            [
                'id'    => '2',
                'todo'  => 'budi'
            ]
        ];

        $this->todolistService->saveTodo('1','eko');
        $this->todolistService->saveTodo('2','budi');

        self::assertEquals($todolist, $this->todolistService->getTodo());
    }

    public function testRemoveTodo()
    {
        $this->todolistService->saveTodo('1','eko');
        $this->todolistService->saveTodo('2','budi');

        self::assertEquals(2, sizeof($this->todolistService->getTodo()));

        $this->todolistService->removeTodo('3');
        self::assertEquals(2, sizeof($this->todolistService->getTodo()));

        $this->todolistService->removeTodo('1');
        self::assertEquals(1, sizeof($this->todolistService->getTodo()));

        $this->todolistService->removeTodo('2');
        self::assertEquals(0, sizeof($this->todolistService->getTodo()));

        self::assertEquals([], $this->todolistService->getTodo());
    }


}
