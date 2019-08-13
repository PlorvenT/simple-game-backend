<?php
/**
 * Copyright © 2019 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace App\Components\awards;


use App\Components\awards\experience\ExperienceCalculator;
use App\Components\awards\experience\ExperienceCalculatorInterface;
use App\Components\awards\gold\GoldCalculator;
use App\Components\awards\gold\GoldCalculatorInterface;
use App\Models\Fight;

class DefaultAwardFactory implements AwardFactory
{
    /**
     * @var Fight
     */
    public $fight;

    public function __construct(Fight $fight)
    {
        $this->fight = $fight;
    }

    public function makeGoldCalculator(): GoldCalculatorInterface
    {
        return new GoldCalculator($this->fight);
    }

    public function makeExperienceCalculator(): ExperienceCalculatorInterface
    {
        return new ExperienceCalculator($this->fight);
    }
}