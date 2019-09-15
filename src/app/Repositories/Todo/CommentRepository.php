<?php

namespace App\Repositories\Todo;

use App\Repositories\Todo\CommentRepositoryInterface;
use App\Models\Todo\Comment;
use App\Models\Todo\CommentId;
use App\Infrastructure\Eloquent\Todo\CommentEloquent;
use App\Infrastructure\Eloquent\Todo\TreePathEloquent;
use App\Models\Todo\TodoId;
use App\Models\User\UserId;
use DB;
use Illuminate\Support\Collection;

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
     * @return CommentId|null
     */
    public function createComment(Comment $comment, CommentId $parentCommentId) : ?CommentId
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

        return is_null($commentEloquent->id) ?
            null:
            new CommentId($commentEloquent->id);
    }

    /**
     * Comment idに紐づいたコメント一覧を取得する
     *
     * @param CommentId $commentId
     * @return Comment[]
     */
    public function getCommentsFromCommentId(CommentId $commentId) : Collection
    {
        $comments = $this->treePathEloquent::with('descendant')
            ->where(
                'ancestor_id',
                $commentId->getId()
            )
            ->get();

        return $comments->map(
            function ($comment) {
                return new Comment(
                    new UserId($comment->descendant->user_id),
                    new TodoId($comment->descendant->todo_id),
                    $comment->descendant->comment
                );
            }
        );
    }
}
