<?php
/**
 * Copyright © 2019 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace App\Components\awards;

use App\Components\awards\experience\ExperienceCalculatorInterface;
use App\Components\awards\experience\PoorExperienceCalculator;
use App\Components\awards\gold\GoldCalculatorInterface;
use App\Components\awards\gold\PoorGoldCalculator;
use App\Models\Fight;

/**
 * Class PoorAwardFactory
 * @package App\Components\awards
 */
class PoorAwardFactoryInterface implements AwardFactoryInterface
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
        return new PoorGoldCalculator($this->fight);
    }

    public function makeExperienceCalculator(): ExperienceCalculatorInterface
    {
        return new PoorExperienceCalculator($this->fight);
    }


}