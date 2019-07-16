<?php
/**
 * Copyright © 2019 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace App\Components\fight;

use App\Models\Hero;
use App\Models\UnitInterface;

/**
 * Interface FightInterface
 * @package App\Components\fight
 */
interface FightInterface
{
    /**
     * This method sets fight's participants.
     *
     * @param Hero $hero
     * @param UnitInterface $unit
     * @return FightInterface
     */
    public function setFighters(Hero $hero, UnitInterface $unit): FightInterface;

    /**
     * This method processing fight and calculates who win.
     *
     * @return FightInterface
     */
    public function process(): FightInterface;

    /**
     * This method calculates all awards
     *
     * @return FightInterface
     */
    public function processAward(): FightInterface;

    /**
     * This method returns if hero win fight
     *
     * @return bool
     */
    public function isHeroWin(): bool;

    /**
     * This method returns gold award. If Hero has lost fight then return null.
     *
     * @return int|null
     */
    public function getGoldAward(): ?int;

    /**
     * This method returns experience award. If Hero has lost fight then return null.
     *
     * @return int|null
     */
    public function getExpAward(): ?int;
}
