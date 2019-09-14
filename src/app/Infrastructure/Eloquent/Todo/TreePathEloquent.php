<?php

namespace App\Infrastructure\Eloquent\Todo;

use Illuminate\Database\Eloquent\Model;

class TreePathEloquent extends Model
{
    protected $table = 'tree_paths';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ancestor',
        'descendant',
    ];
}
