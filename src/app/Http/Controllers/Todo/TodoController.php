<?php

namespace App\Http\Controllers\Todo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Todo\TodoRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Http\Requests\Todo\GetTodoRequest;
use App\Http\Requests\Todo\SetTodoRequest;
use App\Models\Todo\Todo;
use App\Models\Todo\TodoId;
use App\Models\User\UserId;

class TodoController extends Controller
{
    /** @var TodoRepositoryInterface */
    private $todoRepositoryInterface;

    /**
     * constructor
     *
     * @param TodoRepositoryInterface $todoRepositoryInterface
     */
    public function __construct(
        TodoRepositoryInterface $todoRepositoryInterface
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
    public function getTodosByUserId(GetTodoRequest $request, $id) : JsonResponse
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

    /**
     * IdからTodoを追加する
     *
     * @param SetTodoRequest $request
     * @param [type] $id
     * @param [type] $comment
     * @return JsonResponse
     */
    public function createTodoByUserId(SetTodoRequest $request, $id) : JsonResponse
    {
        $title = $request->input('title');
        $comment = $request->input('comment');

        $createdTodoId = $this->todoRepositoryInterface->createTodo(
            new Todo(
                new UserId((int)$id),
                $comment,
                $title
            )
        );

        if (is_null($createdTodoId)) {
            // nullならUserおかしい
            return response()->json(
                [
                    'result' => false,
                    'response' => [],
                    'message' => "This user doesn't exist",
                ]
            );
        } else {
            return response()->json(
                [
                    'result' => true,
                    'response' => [
                        'todo_id' => $createdTodoId->toArray(),
                    ],
                    'message' => 'Todo is made correctly',
                ]
            );
        }
    }
}
