<?php

namespace App\Repositories;

use App\Repositories\UserRepositoryInterface;
use App\Models\User\User;
use App\Models\User\UserId;
use Illuminate\Support\Facades\Hash;
use App\Infrastructure\Eloquent\UserEloquent;

class UserRepository implements UserRepositoryInterface
{
    /**
     * UserEloquent
     *
     * @var UserEloquent
     */
    private $userEloquent;

    public function __construct(UserEloquent $userEloquent)
    {
        $this->userEloquent = $userEloquent;
    }

    /**
     * ユーザーの作成
     *
     * @param User $user
     * @return UserId
     */
    public function createUser(User $user) : UserId
    {
        $userEloquent = $this->userEloquent->create(
            [
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
            ]
        );

        return new UserId($userEloquent->id);
    }

    /**
     * UserIDからユーザーを探す
     *
     * @param UserId $id
     * @return User|null
     */
    public function findByUserId(UserId $id) : ?User
    {
        $user = $this->userEloquent->find($id->getId());

        if (is_null($user)) {
            return null;
        }

        return new User(
            $user->name,
            $user->email,
            $user->password
        );
    }
}
