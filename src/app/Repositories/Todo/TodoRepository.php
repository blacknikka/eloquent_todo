<?php

namespace App\Repositories\Todo;

use App\Repositories\Todo\TodoRepositoryInterface;
use App\Models\Todo\Todo;
use App\Models\Todo\TodoId;
use App\Models\User\UserId;
use App\Infrastructure\Eloquent\Todo\TodoEloquent;
use App\Infrastructure\Eloquent\UserEloquent;
use Illuminate\Support\Collection;

class TodoRepository implements TodoRepositoryInterface
{
    /**
     * TodoEloquent
     *
     * @var TodoEloquent
     */
    private $todoEloquent;

    /** @var UserEloquent */
    private $userEloquent;

    public function __construct(
        TodoEloquent $todoEloquent,
        UserEloquent $userEloquent
    )
    {
        $this->todoEloquent = $todoEloquent;
        $this->userEloquent = $userEloquent;
    }

    /**
     * Todoの作成
     *
     * @param Todo $todo
     * @return TodoId|null
     */
    public function createTodo(Todo $todo) : ?TodoId
    {
        $user = $this->userEloquent::find($todo->getUserId()->getId());

        if (is_null($user)) {
            // userが見つからなかったらnull
            return null;
        }

        $todoEloquent = $this->todoEloquent::create(
            [
                'user_id' => $todo->getUserId()->getId(),
                'comment' => $todo->getComment(),
                'title' => $todo->getTitle(),
            ]
        );

        return new TodoId($todoEloquent->id);
    }

    /**
     * TodoIDからユーザーを探す
     *
     * @param TodoId $id
     * @return Todo|null
     */
    public function findByTodoId(TodoId $id) : ?Todo
    {
        $todo = $this->todoEloquent::find($id->getId());

        if (is_null($todo)) {
            return null;
        }

        return new Todo(
            new UserId($todo->user->id),
            $todo->comment,
            $todo->title
        );
    }

    /**
     * UserIdからTodoのリストを取得する
     *
     * @param UserId $id
     * @return Todo[]|null
     */
    public function getTodosByUserId(UserId $id) : ?Collection
    {
        $todos = $this->todoEloquent::with('user')
            ->where('user_id', $id->getId())
            ->get();

        return $todos->map(
            function ($todo) {
                return new Todo(
                    new UserId($todo->user->id),
                    $todo->comment,
                    $todo->title
                );
            }
        );
    }
}
