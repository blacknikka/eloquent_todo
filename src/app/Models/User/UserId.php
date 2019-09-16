<?php

namespace App\Models\User;

class UserId
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

    /**
     * to array
     *
     * @return array
     */
    public function toArray() : array
    {
        return [
            'id' => $this->id,
        ];
    }
}
