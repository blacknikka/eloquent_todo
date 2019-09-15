<?php

namespace App\Models\Todo;

class CommentId
{
    private $id;

    /**
     * コンストラクタ
     *
     * @param int $id
     */
    public function __construct(
        int $id
    )
    {
        $this->id = $id;
    }

    /**
     * idの取得
     *
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }
}
