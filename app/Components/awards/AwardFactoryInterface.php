<?php
/**
 * Copyright © 2019 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace App\Components\awards;

use App\Components\awards\experience\ExperienceCalculatorInterface;
use App\Components\awards\gold\GoldCalculatorInterface;
use App\Models\Fight;

/**
 * Interface AwardFactory
 * @package App\Components\awards
 */
interface AwardFactoryInterface
{
    public function __construct(Fight $fight);

    public function makeGoldCalculator(): GoldCalculatorInterface;

    public function makeExperienceCalculator(): ExperienceCalculatorInterface;
}
