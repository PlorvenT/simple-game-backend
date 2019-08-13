<?php
/**
 * Copyright © 2019 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace App\Components\awards\gold;

use App\Components\awards\AbstractAwardCalculator;

/**
 * Class GoldCalculator
 * @package App\Components\awards\gold
 */
class GoldCalculator extends AbstractAwardCalculator implements GoldCalculatorInterface
{
    /**
     * @var int
     */
    public const GOLD_FOR_ENEMY_MULTIPLIER = 20;


    /**
     * This method calculates award.
     *
     * @return int
     */
    public function calculate(): int
    {
        if (!$this->fight->isWin()) {
            return 0;
        }

        return $this->fight->enemy->getLvl() * rand(1, self::GOLD_FOR_ENEMY_MULTIPLIER);
    }
}
