<?php

namespace App\Models\Todo;

use App\Models\User\UserId;
use App\Models\Todo\TodoId;

class Comment
{
    /**
     * User id
     *
     * @var UserId
     */
    private $userId;

    /**
     * Todo Id
     *
     * @var TodoId
     */
    private $todoId;

    /**
     * comment
     *
     * @var string
     */
    private $comment;

    /**
     * コンストラクタ
     *
     * @param UserId $userId
     * @param TodoId $todoId
     * @param string $comment
     */
    public function __construct(
        UserId $userId,
        TodoId $todoId,
        string $comment
    )
    {
        $this->userId = $userId;
        $this->todoId = $todoId;
        $this->comment = $comment;
    }

    /**
     * User id の取得
     *
     * @return UserId
     */
    public function getUserId() : UserId
    {
        return $this->userId;
    }

    /**
     * todo id
     *
     * @return TodoId
     */
    public function  getTodoId() : TodoId
    {
        return $this->todoId;
    }

    /**
     * comment
     *
     * @return string
     */
    public function getComment() : string
    {
        return $this->comment;
    }

    /**
     * to array
     *
     * @return array
     */
    public function toArray() : array
    {
        return [
            'user_id' => $this->userId->toArray(),
            'todo_id' => $this->todoId->toArray(),
            'comment' => $this->comment,
        ];
    }
}
