<?php

namespace App\Http\Controllers\Todo;

use Illuminate\Http\Request;
use App\Http\Requests\Todo\GetCommentRequest;
use App\Http\Controllers\Controller;
use App\Repositories\Todo\CommentRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Models\Todo\TodoId;

class CommentController extends Controller
{
    /** @var CommentRepositoryInterface */
    private $commentRepositoryInterface;

    /**
     * constructor
     *
     * @param CommentRepositoryInterface $commentRepositoryInterface
     */
    public function __construct(
        CommentRepositoryInterface $commentRepositoryInterface
    )
    {
        $this->commentRepositoryInterface = $commentRepositoryInterface;
    }

    public function getCommentsByTodoId(GetCommentRequest $request, $todo_id) : JsonResponse
    {
        $todos = $this->commentRepositoryInterface->getCommentsFromCommentId(
            new TodoId((int)$todo_id)
        );

        return response()->json(
            $todos->map(function (Todo $todo) {
                return $todo->toArray();
            })
        );

    }
}
