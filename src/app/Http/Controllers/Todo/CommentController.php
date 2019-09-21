<?php

namespace App\Http\Controllers\Todo;

use Illuminate\Http\Request;
use App\Http\Requests\Todo\GetCommentRequest;
use App\Http\Requests\Todo\CreateCommentToCommentRequest;
use App\Http\Controllers\Controller;
use App\Repositories\Todo\CommentRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Models\Todo\TodoId;
use App\Models\Todo\Comment;
use App\Models\Todo\CommentId;
use App\Models\User\UserId;
use Illuminate\Support\Facades\Auth;

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

    /**
     * create comment to comment.
     *
     * @param CreateCommentToCommentRequest $request
     * @return JsonResponse
     */
    public function createCommentToComment(CreateCommentToCommentRequest $request) : JsonResponse
    {
        // user
        $user_id = Auth::id();

        $todo_id = $request->input('todo_id');
        $comment_id = $request->input('comment_id');
        $comment = $request->input('comment');

        $createdComment = $this->commentRepositoryInterface->createComment(
            new Comment(
                new UserId($user_id),
                new TodoId((int)$todo_id),
                $comment
            ),
            is_null($comment_id) ? null: new CommentId((int)$comment_id)
        );

        if (is_null($createdComment)) {
            return response()->json(
                [
                    'result' => false,
                    'id' => null,
                ]
            );
        } else {
            return response()->json(
                [
                    'result' => true,
                    'id' => $createdComment->toArray(),
                ]
            );
        }
    }
}
