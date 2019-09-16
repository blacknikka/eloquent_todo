<?php

namespace App\Models\Todo;

use App\Models\User\UserId;

class Todo
{
    /**
     * User id
     *
     * @var UserId
     */
    private $userId;

    /**
     * Comment
     *
     * @var string
     */
    private $comment;

    /**
     * Title
     *
     * @var string
     */
    private $title;

    /**
     * コンストラクタ
     *
     * @param UserId $userId
     * @param string $comment
     * @param string $title
     */
    public function __construct(
        UserId $userId,
        string $comment,
        string $title
    )
    {
        $this->userId = $userId;
        $this->comment = $comment;
        $this->title = $title;
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
     * comment
     *
     * @return string
     */
    public function getComment() : string
    {
        return $this->comment;
    }

    /**
     * title
     *
     * @return string
     */
    public function  getTitle() : string
    {
        return $this->title;
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
            'comment' => $this->comment,
            'title' => $this->title,
        ];
    }
}
