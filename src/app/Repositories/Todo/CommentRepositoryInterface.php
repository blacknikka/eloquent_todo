<?php

namespace App\Repositories\Todo;

use App\Models\Todo\Comment;
use App\Models\Todo\CommentId;
use App\Models\Todo\TodoId;
use Illuminate\Support\Collection;

/**
 * Commentデータの永続化層
 */
interface CommentRepositoryInterface
{
    /**
     * create comment
     *
     * @param Comment $comment
     * @param CommentId|null $parentCommentId
     * @return CommentId|null
     */
    public function createComment(Comment $comment, ?CommentId $parentCommentId) : ?CommentId;

    /**
     * get comments from Todo id.
     *
     * @param TodoId $todoId
     * @return Collection
     */
    public function getCommentsFromTodoId(TodoId $todoId) : Collection;

    /**
     * get comments by comment id
     *
     * @param CommentId $commentId
     * @return Collection
     */
    public function getCommentsFromCommentId(CommentId $commentId) : Collection;
}
