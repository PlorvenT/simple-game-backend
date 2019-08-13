<?php
/**
 * Copyright © 2019 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FightLogs
 *
 * @property integer $id
 * @property integer $fight_id
 * @property string $type
 * @property string $description
 * @property integer $created_at
 *
 * @mixin \Eloquent
 * @package App
 */
class FightLogs extends Model
{
    /**
     * @var string
     */
    public const TYPE_HERO_ATTACK_ENEMY = 'hero_attack_enemy';

    /**
     * @var string
     */
    public const TYPE_ENEMY_ATTACK_HERO = 'enemy_attack_hero';

    /**
     * @var string
     */
    public const TYPE_END = 'end';

    /**
     * @var array
     */
    public static $types = [
        self::TYPE_HERO_ATTACK_ENEMY,
        self::TYPE_ENEMY_ATTACK_HERO,
        self::TYPE_END,
    ];

    /**
     * @var string
     */
    public $table = 'fight_logs';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['fight_id', 'type', 'created_at'];

    public function fight()
    {
        $this->belongsTo(Fight::class);
    }
}
