<?php
/**
 * Copyright © 2019 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace App\Components\fight;

use App\Components\awards\DefaultAwardFactoryInterface;
use App\Components\awards\PoorAwardFactoryInterface;
use App\Models\Fight;
use App\Components\awards\AwardFactoryInterface as AwardFactoryInterface;

/**
 * Class AwardFactory
 * @package App\Components\fight
 */
class AwardFactory
{
    /**
     * @param Fight $fight
     * @return AwardFactoryInterface
     */
    public static function make(Fight $fight): AwardFactoryInterface
    {
        if ($fight->hero->user->hasBan()) {
            return new PoorAwardFactoryInterface($fight);
        }

        return new DefaultAwardFactoryInterface($fight);
    }
}
