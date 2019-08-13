<?php
/**
 * Copyright © 2019 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace App\Components\awards\experience;

/**
 * Interface ExperienceCalculatorInterface
 * @package App\Components\awards\experience
 */
interface ExperienceCalculatorInterface
{
    /**
     * This method calculates award.
     *
     * @return int
     */
    public function calculate(): int;
}
