<?php

namespace App\Infrastructure\Eloquent\Todo;

use Illuminate\Database\Eloquent\Model;
use App\Infrastructure\Eloquent\UserEloquent;
use App\Infrastructure\Eloquent\Todo\TodoEloquent;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    /**
     * Get user by Comment.
     *
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(UserEloquent::class);
    }

    /**
     * Get todo by Comment.
     *
     * @return BelongsTo
     */
    public function todo() : BelongsTo
    {
        return $this->belongsTo(TodoEloquent::class);
    }
}
