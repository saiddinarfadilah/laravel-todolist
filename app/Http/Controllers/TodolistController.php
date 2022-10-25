<?php

namespace App\Http\Controllers;

use App\Services\TodolistService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TodolistController extends Controller
{
    private TodolistService $todolistService;

    /**
     * @param TodolistService $todolistService
     */
    public function __construct(TodolistService $todolistService)
    {
        $this->todolistService = $todolistService;
    }

    public function todolist(Request $request):Response
    {
        $todolist = $this->todolistService->getTodo();

        return response()->view('todolist.todolist', [
            'title'     => 'todolist',
            'todolist'  => $todolist
        ]);
    }

    public function saveTodo(Request $request)
    {
        $todo = $request->input('todo');

        //validaste input
        if (empty($todo)){
            $todolist = $this->todolistService->getTodo();
            return response()->view('todolist.todolist', [
                'title'     => 'todolist',
                'todolist'  => $todolist,
                'error'     => 'todo is required'
            ]);
        }

        $this->todolistService->saveTodo(uniqid(), $todo);

        return redirect()->action([TodolistController::class, 'todolist']);
    }

    public function removeTodo(Request $request, string $todoId):RedirectResponse
    {
        $this->todolistService->removeTodo($todoId);
        return redirect()->action([TodolistController::class, 'todolist']);
    }
}
