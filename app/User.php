<?php

namespace App;

use App\Models\Hero;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

/**
 * Class User
 *
 * @property integer $id
 * @property string $api_token
 * @property string $gold_balance
 *
 * @mixin \Eloquent
 * @package App
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return HasMany|Article[]
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    /**
     * @return HasMany|Hero[]
     */
    public function heroes()
    {
        return $this->hasMany(Hero::class);
    }

    /**
     * @return HasMany|Comment[]
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @return string
     */
    public function generateToken()
    {
        $this->api_token = Str::random(60);
        $this->save();

        return $this->api_token;
    }

    /**
     * @param int $gold
     * @return bool
     */
    public function updateBalance(int $gold): bool
    {
        if ($gold <= 0) {
            return false;
        }

        $this->gold_balance += $gold;
        return $this->save();
    }

    public function hasBan()
    {
        return false;
    }
}
