<?php

namespace App\Repositories\Todo;

use App\Models\Todo\Comment;
use App\Models\Todo\CommentId;

/**
 * Commentデータの永続化層
 */
interface CommentRepositoryInterface
{
    /**
     * create comment
     *
     * @param Comment $comment
     * @param CommentId $parentCommentId
     * @return CommentId
     */
    public function createComment(Comment $comment, CommentId $parentCommentId) : CommentId;
}
