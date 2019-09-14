<?php

namespace App\Repositories;

use App\Models\User\User;
use App\Models\User\UserId;

/**
 * Userの永続化層
 */
interface UserRepositoryInterface
{
    /**
     * ユーザー作成
     *
     * @param User $user
     * @return UserId
     */
    public function createUser(User $user) : UserId;

    /**
     * ユーザー取得
     *
     * @param UserId $id
     * @return User|null
     */
    public function findByUserId(UserId $id) : ?User;
}
