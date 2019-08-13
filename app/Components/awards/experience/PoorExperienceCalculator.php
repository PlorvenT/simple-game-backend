<?php
/**
 * Copyright © 2019 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace App\Components\awards\experience;

use App\Components\awards\AbstractAwardCalculator;

/**
 * Class PoorExperienceCalculator
 * @package App\Components\awards\experience
 */
class PoorExperienceCalculator extends AbstractAwardCalculator implements ExperienceCalculatorInterface
{
    /**
     * This method calculates award.
     *
     * @return int
     */
    public function calculate(): int
    {
        return $this->fight->enemy->lvl;
    }
}
