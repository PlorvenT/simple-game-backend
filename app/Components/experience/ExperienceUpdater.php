<?php
/**
 * Copyright © 2019 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace App\Components\experience;

use App\Models\Hero;

/**
 * Class ExperienceUpdater
 * @package App\Components\experience
 */
class ExperienceUpdater
{
    /**
     * @var int
     */
    public const LVL_MULTIPLIER = 100;

    /**
     * This method updates hero exp and lvl.
     *
     * @param Hero $hero
     * @param int $experience
     *
     * @return Hero
     */
    public function update(Hero $hero, int $experience)
    {
        if ($experience <= 0) {
            return $hero;
        }

        $hero->experience += $experience;

        $lvlGreed = self::buildHeroLvlGreed();
        $newLvl = $this->getHeroLvlByExp($lvlGreed, $hero->experience);
        $hero->updateLvl($newLvl);

        $hero->save();

        return $hero;
    }

    /**
     * Recursive method for getting user lvl by experience.
     *
     * @param $lvlGreed
     * @param $experience
     * @param $lvl
     * @return int
     */
    public function getHeroLvlByExp($lvlGreed, $experience, $lvl = 1)
    {
        //exit from recursion when lower then 1 lvl
        if ($experience <= $lvlGreed[1]) {
            return 1;
        }

        //exit from recursion when biggest then 1 lvl
        if ($experience >= $lvlGreed[Hero::MAX_LVL]) {
            return Hero::MAX_LVL;
        }

        if ($experience >= $lvlGreed[$lvl] && $experience < $lvlGreed[$lvl + 1]) {
            return $lvl + 1;
        }

        return $this->getHeroLvlByExp($lvlGreed, $experience, ($lvl + 1));
    }

    /**
     * This method builds lvl greed. Key of array is lvl and value is highest limit before lvl-up.
     *
     * @return array
     */
    public static function buildHeroLvlGreed(): array
    {
        $lvlGreed = [];
        for ($i = 1; $i <= Hero::MAX_LVL; $i++)
        {
            $lvlGreed[$i] = $i * $i * self::LVL_MULTIPLIER;
        }

        return $lvlGreed;
    }
}
