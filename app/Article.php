<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Article
 *
 * @property integer $user_id
 * @mixin \Eloquent
 * @package App
 */
class Article extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['title', 'body'];

    /**
     * @var array
     */
    public static $createRules = [
        'title' => 'required|string|max:255',
        'body' => 'required',
    ];

    public function user()
    {
        $this->belongsTo(User::class);
    }

    /**
     * @return HasMany|Comment[]
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
