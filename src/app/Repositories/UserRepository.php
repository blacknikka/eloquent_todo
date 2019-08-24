<?php

namespace App\Repositories;

use App\Repositories\UserRepositoryInterface;
use App\Models\User\User;
use App\Models\User\UserId;
use App\Models\User\Profile;
use App\Models\User\ProfileId;
use App\Infrastructure\Eloquent\UserEloquent;
use App\Infrastructure\Eloquent\ProfileEloquent;

class UserRepository implements UserRepositoryInterface
{
    /**
     * UserEloquent
     *
     * @var UserEloquent
     */
    private $userEloquent;

    /**
     * ProfileEloquent
     *
     * @var ProfileEloquent
     */
    private $profileEloquent;

    public function __construct(
        UserEloquent $userEloquent,
        ProfileEloquent $profileEloquent
    )
    {
        $this->userEloquent = $userEloquent;
        $this->profileEloquent = $profileEloquent;
    }

    /**
     * ユーザーの作成
     *
     * @param User $user
     * @return UserId
     */
    public function createUser(User $user) : UserId
    {
        $userEloquent = $this->userEloquent::create(
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
        $user = $this->userEloquent::find($id->getId());

        if (is_null($user)) {
            return null;
        }

        return new User(
            $user->name,
            $user->email,
            $user->password
        );
    }

    /**
     * Profileを登録する
     *
     * @param Profile $profile
     * @return ProfileId|null
     */
    public function createUserProfile(UserId $uid, Profile $profile) : ?ProfileId
    {
        if ($this->userEloquent::where('id', $uid->getId())->exists() === true) {
            $profileEloquent = $this->profileEloquent::create(
                [
                    'user_id' => $uid,
                    'displayName' => $profile->getDisplayName(),
                    'comment' => $profile->getComment(),
                ]
            );
        }

        // 存在しない場合にはnullを返す
        return null;
    }
}
