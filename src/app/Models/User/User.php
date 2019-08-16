<?php

namespace App\Models\User;

class User
{
    private $name;

    private $email;

    private $password;

    /**
     * コンストラクタ
     *
     * @param string $name
     * @param string $email
     * @param string $password
     */
    public function __construct(
        string $name,
        string $email,
        string $password
    )
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * 名前の取得
     *
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Email
     *
     * @return string
     */
    public function getEmail() : string
    {
        return $this->email;
    }

    /**
     * パスワード取得
     *
     * @return string
     */
    public function  getPassword() : string
    {
        return $this->password;
    }
}
