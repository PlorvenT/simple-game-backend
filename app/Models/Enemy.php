<?php
/**
 * Copyright © 2019 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Enemy
 *
 * @property integer $id
 * @property string $name
 * @property string $type
 * @property integer $lvl
 * @property integer $attack
 * @property integer $heatpoint
 *
 * @mixin \Eloquent
 * @package App
 */
class Enemy extends Model implements UnitInterface
{
    /**
     * @var string
     */
    public const TYPE_FISH = 'fish';

    /**
     * @var string
     */
    public const TYPE_WOLF = 'wolf';

    /**
     * @var array
     */
    public const ENEMY_TYPES = [self::TYPE_FISH, self::TYPE_WOLF];

    /**
     * @var array
     */
    protected $fillable = ['name', 'type', 'lvl', 'attack', 'heatpoint'];

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
        return $this->heatpoint;
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
}
