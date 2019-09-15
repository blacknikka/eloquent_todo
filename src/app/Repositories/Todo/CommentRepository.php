<?php

namespace App\Repositories\Todo;

use App\Repositories\Todo\CommentRepositoryInterface;
use App\Models\Todo\Comment;
use App\Models\Todo\CommentId;
use App\Infrastructure\Eloquent\Todo\CommentEloquent;
use App\Infrastructure\Eloquent\Todo\TreePathEloquent;
use DB;

class CommentRepository implements CommentRepositoryInterface
{
    /**
     * CommentEloquent
     *
     * @var CommentEloquent
     */
    private $commentEloquent;

    /**
     * treePathEloquent
     *
     * @var TreePathEloquent
     */
    private $treePathEloquent;

    public function __construct(
        CommentEloquent $commentEloquent,
        TreePathEloquent $treePathEloquent
    )
    {
        $this->commentEloquent = $commentEloquent;
        $this->treePathEloquent = $treePathEloquent;
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
        $commentEloquent = DB::transaction(function () use ($comment, $parentCommentId) {
            $commentEloquent = $this->commentEloquent::create(
                [
                    'user_id' => $comment->getUserId()->getId(),
                    'todo_id' => $comment->getTodoId()->getId(),
                    'comment' => $comment,
                ]
            );

            // insert a tree path.
            $this->treePathEloquent::create(
                [
                    'ancestor_id' => $parentCommentId->getId(),
                    'descendant_id' => $commentEloquent->id,
                ]
            );

            return $commentEloquent;
        });

        return new CommentId($commentEloquent->id);
    }
}
