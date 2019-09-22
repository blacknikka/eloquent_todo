<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repositories\UserRepositoryInterface;
use App\Models\User\UserId;
use Illuminate\Support\Facades\Auth;

class ApiTokenController extends Controller
{
    /** @var UserRepositoryInterface */
    private $userRepositoryInterface;

    /**
     * constructor
     *
     * @param UserRepositoryInterface $userRepositoryInterface
     */
    public function __construct(
        UserRepositoryInterface $userRepositoryInterface
    )
    {
        $this->userRepositoryInterface = $userRepositoryInterface;
    }

    /**
     * 認証済みのユーザーのAPIトークンを更新する
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function updateApiToken(Request $request) : JsonResponse
    {
        $userId = Auth::id();

        if (is_null($userId)) {
            return response()->json(
                [
                    'token' => null,
                ]
            );
        }

        $token = $this->userRepositoryInterface->updateApiToken(new UserId($userId));

        if (is_null($token)) {
            return response()->json(
                [
                    'token' => null,
                ]
            );
        } else {
            return response()->json(
                [
                    'token' => $token,
                ]
            );
        }
    }
}
