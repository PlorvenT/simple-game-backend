<?php
/**
 * Copyright © 2019 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace App\Models;

use App\Components\awards\gold\GoldCalculator;
use App\Components\experience\ExperienceUpdater;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Fight
 *
 * @property integer $id
 * @property integer $hero_id
 * @property integer $enemy_id
 * @property integer $date_start
 * @property integer $date_end
 * @property integer $gold_award
 * @property integer $experience_award
 * @property string $status
 *
 * @property Hero $hero
 * @property Enemy $enemy
 * @property FightLogs[] $fightLogs
 *
 * @mixin Eloquent
 * @package App\Models
 */
class Fight extends Model
{
    /**
     * @var string
     */
    public const STATUS_WIN_HERO = 'win';

    /**
     * @var string
     */
    public const STATUS_LOSE_HERO = 'lose';

    /**
     * @var string
     */
    public const STATUS_IN_PROGRESS = 'in_progress';

    /**
     * @var array
     */
    public static $winStatuses = [self::STATUS_IN_PROGRESS, self::STATUS_WIN_HERO, self::STATUS_LOSE_HERO];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['hero_id', 'enemy_id', 'date_start'];

    /**
     * @return HasMany|FightLogs[]
     */
    public function fightLogs()
    {
        return $this->hasMany(FightLogs::class);
    }

    /**
     * @return BelongsTo|Enemy
     */
    public function enemy()
    {
        return $this->belongsTo(Enemy::class);
    }

    /**
     * @return BelongsTo|Hero
     */
    public function hero()
    {
        return $this->belongsTo(Hero::class);
    }

    public function isWin(): bool
    {
        return $this->status == self::STATUS_WIN_HERO;
    }
}
