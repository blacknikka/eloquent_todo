<?php

namespace App\Infrastructure\Eloquent;

use Illuminate\Database\Eloquent\Model;
use App\Infrastructure\Eloquent\UserEloquent;

class ProfileEloquent extends Model
{
    protected $table = 'profiles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'displayName',
        'comment',
    ];

    /**
     * Get user by Profile.
     */
    public function user()
    {
        return $this->belongsTo(UserEloquent::class);
    }

}
