<?php
/**
 * Copyright © 2019 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace App\Components\fight;

/**
 * Class FightService
 * @package App\Components\fight
 */
class FightService extends AbstractFight
{
    /**
     * This method calculates gold awards.
     *
     * @return int
     */
    public function calculateGoldAward(): int
    {
        if (!$this->isWin) {
            return 0;
        }

        return $this->enemy->getLvl() * rand(1, self::GOLD_FOR_ENEMY_MULTIPLIER);
    }

    /**
     * This method calculates experience awards.
     *
     * @return int
     */
    public function calculateExpAward(): int
    {
        if (!$this->isWin) {
            return 0;
        }

        if (($this->hero->lvl - $this->enemy->getLvl()) > self::MAX_LVL_DIFFERENCE_FOR_EXP) {
            return 0;
        }

        return $this->enemy->getLvl() * self::EXP_FOR_ENEMY_MULTIPLIER;
    }
}
