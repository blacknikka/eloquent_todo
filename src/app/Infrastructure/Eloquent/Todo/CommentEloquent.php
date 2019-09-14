<?php

namespace App\Infrastructure\Eloquent\Todo;

use Illuminate\Database\Eloquent\Model;

class CommentEloquent extends Model
{
    protected $table = 'comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'todo_id',
        'user_id',
        'comment',
    ];

}
