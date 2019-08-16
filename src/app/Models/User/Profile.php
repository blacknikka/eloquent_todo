<?php

namespace App\Models\User;

use App\Models\User\UserId;

class Profile
{
    /**
     * UserId
     *
     * @var UserId $userId
     */
    private $userId;

    /**
     * 表示名
     *
     * @var string
     */
    private $displayName;

    /**
     * コメント
     *
     * @var stirng
     */
    private $comment;

    /**
     * コンストラクタ
     *
     * @param UserId $userId
     * @param string $displayName
     * @param string $comment
     */
    public function __construct(
        UserId $userId,
        string $displayName,
        string $comment
    )
    {
        $this->userId = $userId;
        $this->displayName = $displayName;
        $this->comment = $comment;
    }

    /**
     * UserId
     *
     * @return UserId
     */
    public function getUserId() : UserId
    {
        return $this->userId;
    }

    /**
     * 表示名
     *
     * @return string
     */
    public function getDisplayName() : string
    {
        return $this->displayName;
    }

    /**
     * コメント
     *
     * @return string
     */
    public function  getComment() : string
    {
        return $this->comment;
    }
}
