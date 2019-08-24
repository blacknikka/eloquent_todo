<?php

namespace App\Models\User;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends  Authenticatable
{
    use Notifiable;

    private $name;

    private $email;

    /**
     * ハッシュされたパスワード文字列
     *
     * @var [type]
     */
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

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

}
