<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Article
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
        'title' => 'required',
        'body' => 'required',
    ];

    /**
     *
     */
    public function user()
    {
        $this->belongsTo(User::class);
    }
}
