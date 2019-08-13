<?php
/**
 * Copyright © 2019 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace App\Components\fight;

use App\Components\awards\DefaultAwardFactory;
use App\Components\awards\PoorAwardFactory;
use App\Models\Fight;
use App\Components\awards\AwardFactory as AwardFactoryInterface;

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
            return new PoorAwardFactory($fight);
        }

        return new DefaultAwardFactory($fight);
    }
}
