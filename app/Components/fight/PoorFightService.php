<?php
/**
 * Copyright © 2019 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace App\Components\fight;

/**
 * Class PoorFightService
 * @package App\Components\fight
 */
class PoorFightService extends AbstractFight
{
    /**
     * @inheritDoc
     */
    public function calculateGoldAward(): int
    {
        if (!$this->isWin) {
            return 0;
        }

        return 2;
    }

    /**
     * @inheritDoc
     */
    public function calculateExpAward(): int
    {
        return 0;
    }
}