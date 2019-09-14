<?php

namespace App\Infrastructure\Eloquent\Todo;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;
use \Illuminate\Database\Eloquent\Relations\HasOne;
use App\Infrastructure\Eloquent\Todo\CommentEloquent;

class TreePathEloquent extends Model
{
    protected $table = 'tree_paths';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ancestor_id',
        'descendant_id',
    ];

    /**
     * Get comment by TreePath.
     *
     * @return BelongsTo
     */
    public function ancestor() : BelongsTo
    {
        return $this->belongsTo(CommentEloquent::class, 'ancestor_id');
    }

    /**
     * Get Comment by TreePath.
     *
     * @return BelongsTo
     */
    public function descendant() : BelongsTo
    {
        return $this->belongsTo(CommentEloquent::class, 'descendant_id');
    }
}
