<?php

namespace App\Repositories\Todo;

use App\Models\Todo\Todo;
use App\Models\Todo\TodoId;

/**
 * Todoデータの永続化層
 */
interface TodoRepositoryInterface
{
    /**
     * Todo作成
     *
     * @param Todo $todo
     * @return TodoId
     */
    public function createTodo(Todo $todo) : TodoId;

    /**
     * Todo取得
     *
     * @param TodoId $id
     * @return Todo|null
     */
    public function findByTodoId(TodoId $id) : ?Todo;
}