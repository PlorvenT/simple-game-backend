<?php
/**
 * Copyright © 2019 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace App\Components\awards\gold;

use App\Components\awards\AbstractAwardCalculator;

/**
 * Class PoorGoldCalculator
 * @package App\Components\awards\gold
 */
class PoorGoldCalculator extends AbstractAwardCalculator implements GoldCalculatorInterface
{
    /**
     * This method calculates award.
     *
     * @return int
     */
    public function calculate(): int
    {
        return 0;
    }
}
