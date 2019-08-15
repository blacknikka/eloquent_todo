<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use App\Models\User\User;

class Profile extends Model
{
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
        return $this->belongsTo(User::class);
    }

}
