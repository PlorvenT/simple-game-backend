<?php
/**
 * Copyright © 2019 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace App\Components\awards\experience;

use App\Components\awards\AbstractAwardCalculator;

/**
 * Class ExperienceCalculator
 * @package App\Components\awards\experience
 */
class ExperienceCalculator extends AbstractAwardCalculator implements ExperienceCalculatorInterface
{
    /**
     * @var int
     */
    public const MAX_LVL_DIFFERENCE_FOR_EXP = 2;

    /**
     * @var int
     */
    public const EXP_FOR_ENEMY_MULTIPLIER = 10;

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

        if (($this->fight->hero->lvl - $this->fight->enemy->getLvl()) > self::MAX_LVL_DIFFERENCE_FOR_EXP) {
            return 0;
        }

        return $this->fight->enemy->getLvl() * self::EXP_FOR_ENEMY_MULTIPLIER;
    }
}
