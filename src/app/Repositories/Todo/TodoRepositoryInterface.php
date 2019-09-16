<?php

namespace App\Repositories\Todo;

use App\Models\Todo\Todo;
use App\Models\Todo\TodoId;
use App\Models\User\UserId;
use Illuminate\Support\Collection;

/**
 * Todoデータの永続化層
 */
interface TodoRepositoryInterface
{
    /**
     * Todo作成
     *
     * @param Todo $todo
     * @return TodoId|null
     */
    public function createTodo(Todo $todo) : ?TodoId;

    /**
     * Todo取得
     *
     * @param TodoId $id
     * @return Todo|null
     */
    public function findByTodoId(TodoId $id) : ?Todo;

    /**
     * Todoのcollection取得
     *
     * @param UserId $id
     * @return Todo[]|null
     */
    public function getTodosByUserId(UserId $id) : ?Collection;
}
