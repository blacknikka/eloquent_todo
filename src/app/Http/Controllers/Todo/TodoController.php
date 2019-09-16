<?php

namespace App\Http\Controllers\Todo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Todo\TodoRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Http\Requests\Todo\GetTodoRequest;
use App\Models\Todo\Todo;
use App\Models\Todo\TodoId;
use App\Models\User\UserId;

class TodoController extends Controller
{
    /** @var TodoRepositoryInterface */
    private $todoRepositoryInterface;

    public function __construct(
        todoRepositoryInterface $todoRepositoryInterface
    )
    {
        $this->todoRepositoryInterface = $todoRepositoryInterface;
    }

    /**
     * IdからTodoを取得する
     *
     * @param GetTodoRequest $request
     * @return JsonResponse
     */
    public function getTodoByUserId(GetTodoRequest $request, $id) : JsonResponse
    {
        $todos = $this->todoRepositoryInterface->getTodosByUserId(
            new UserId((int)$id)
        );

        return response()->json(
            $todos->map(function (Todo $todo) {
                return $todo->toArray();
            })
        );
    }
}
