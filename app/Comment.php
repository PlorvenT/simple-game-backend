<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Comment
 * @property string $message
 * @mixin \Eloquent
 * @package App
 */
class Comment extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['message', 'article_id'];

    /**
     * @var array
     */
    public static $createRules = [
        'message' => 'required|string|max:255',
        'article_id' => 'required|exists:articles,id',
    ];

    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function article()
    {
        $this->belongsTo(Article::class);
    }
}
