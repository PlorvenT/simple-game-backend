<?php
/**
 * Copyright © 2019 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace App\Models;

use App\Rules\hero\HeroMaxCountRule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

/**
 * Class Hero
 *
 * @property integer $id
 * @property string $name
 * @property string $type
 * @property integer $user_id
 * @property integer $max_heatpoint
 * @property integer $lvl
 * @property integer $attack
 * @property integer $current_heatpoint
 * @property integer $experience
 * @property $created_at
 * @property $updated_at
 *
 * @mixin \Eloquent
 *
 * @package App\Models
 */
class Hero extends Model implements UnitInterface
{
    public const TYPE_TANK = 'tank';
    public const TYPE_DD = 'dd';
    public const TYPE_HEAL = 'heal';

    public const DEFAULT_LVL = 1;
    public const MAX_LVL = 10;

    public const DEFAULT_MAX_HP_TANK = 100;
    public const DEFAULT_MAX_HP_HEAL = 80;
    public const DEFAULT_MAX_HP_DD = 50;

    public const DEFAULT_ATTACK_TANK = 5;
    public const DEFAULT_ATTACK_HEAL = 7;
    public const DEFAULT_ATTACK_DD = 10;

    public const GROWTH_HP_BY_LVL = 50;

    /**
     * @var array
     */
    public static $defaultHp = [
        self::TYPE_TANK => self::DEFAULT_MAX_HP_TANK,
        self::TYPE_DD => self::DEFAULT_MAX_HP_DD,
        self::TYPE_HEAL => self::DEFAULT_MAX_HP_HEAL,
    ];

    /**
     * @var array
     */
    public static $defaultAttack = [
        self::TYPE_TANK => self::DEFAULT_ATTACK_TANK,
        self::TYPE_DD => self::DEFAULT_ATTACK_DD,
        self::TYPE_HEAL => self::DEFAULT_ATTACK_HEAL,
    ];

    /**
     * @var array
     */
    public const TYPES = [self::TYPE_TANK, self::TYPE_DD, self::TYPE_HEAL];

    /**
     * @var array
     */
    protected $fillable = ['name', 'type', 'max_heatpoint', 'lvl', 'attack', 'current_heatpoint', 'experience'];

    /**
     * @var array
     *
     * @return array
     */
    public static function getCreateRules(): array
    {
        return [
            'name' => ['required', 'string', 'min:6', 'max:50', new HeroMaxCountRule()],
            'type' => ['required', 'string', Rule::in(self::TYPES)],
            'experience' => ['required', 'integer', 'min:0'],
        ];
    }

    /**
     * @inheritDoc
     */
    public function getAttack(): int
    {
        return $this->attack;
    }

    /**
     * @inheritDoc
     */
    public function getCurrentHP(): int
    {
        return $this->current_heatpoint;
    }

    /**
     * @inheritDoc
     */
    public function getProtection(): int
    {
        return $this->lvl;
    }

    /**
     * @inheritDoc
     */
    public function getLvl(): int
    {
        return $this->lvl;
    }

    /**
     * @param $newLvl
     * @return bool
     */
    public function updateLvl($newLvl)
    {
        if ($newLvl <= $this->lvl) {
            return true;
        }
        $this->max_heatpoint = self::$defaultHp[$this->type] + self::GROWTH_HP_BY_LVL * $newLvl;
        $this->current_heatpoint = $this->max_heatpoint;
        $this->lvl = $newLvl;

        return $this->save();
    }
}
