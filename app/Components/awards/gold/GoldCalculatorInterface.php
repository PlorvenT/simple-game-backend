<?php
/**
 * Copyright © 2019 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace App\Components\awards\gold;

/**
 * Interface GoldCalculatorInterface
 * @package App\Components\awards\gold
 */
interface GoldCalculatorInterface
{
    /**
     * This method calculates award.
     *
     * @return int
     */
    public function calculate(): int;
}
