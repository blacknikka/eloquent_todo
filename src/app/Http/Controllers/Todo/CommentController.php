<?php

namespace App\Http\Controllers\Todo;

use Illuminate\Http\Request;
use App\Http\Requests\Todo\GetCommentRequest;
use App\Http\Controllers\Controller;
use App\Repositories\Todo\CommentRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Models\Todo\TodoId;
use App\Models\Todo\Comment;

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

    /**
     * get comments by todo id.
     *
     * @param GetCommentRequest $request
     * @param int $todo_id
     * @return JsonResponse
     */
    public function getCommentsByTodoId(GetCommentRequest $request, $todo_id) : JsonResponse
    {
        $comments = $this->commentRepositoryInterface->getCommentsFromTodoId(
            new TodoId((int)$todo_id)
        );

        return response()->json(
            $comments->map(function (Comment $comment) {
                return $comment->toArray();
            })
        );

    }
}
