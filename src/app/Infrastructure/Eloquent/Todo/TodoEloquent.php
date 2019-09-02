<?php

namespace App\Infrastructure\Eloquent\Todo;

use Illuminate\Database\Eloquent\Model;
use App\Infrastructure\Eloquent\UserEloquent;

class TodoEloquent extends Model
{
    protected $table = 'todos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'comment',
        'title',
    ];

    /**
     * Get user by Profile.
     */
    public function user()
    {
        return $this->belongsTo(UserEloquent::class);
    }
}
