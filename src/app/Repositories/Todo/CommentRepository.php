<?php

namespace App\Repositories\Todo;

use App\Repositories\Todo\CommentRepositoryInterface;
use App\Models\Todo\Comment;
use App\Models\Todo\CommentId;
use App\Infrastructure\Eloquent\Todo\CommentEloquent;

class CommentRepository implements CommentRepositoryInterface
{
    /**
     * CommentEloquent
     *
     * @var CommentEloquent
     */
    private $commentEloquent;

    public function __construct(
        CommentEloquent $commentEloquent
    )
    {
        $this->commentEloquent = $commentEloquent;
    }

    /**
     * Create comment
     * Tree path is also added.
     *
     * @param Comment $comment
     * @param CommentId $parentCommentId Its parent's comment ID
     * @return CommentId
     */
    public function createComment(Comment $comment, CommentId $parentCommentId) : CommentId
    {
        $commentEloquent = $this->commentEloquent::create(
            [
                'user_id' => $comment->getUserId()->getId(),
                'todo_id' => $comment->getTodoId()->getId(),
                'comment' => $comment,
            ]
        );



        return new CommentId($commentEloquent->getId());
    }
}
