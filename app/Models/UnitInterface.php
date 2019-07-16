<?php
/**
 * Copyright © 2019 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace App\Models;

/**
 * Interface UnitInterface
 * @package App\Models
 */
interface UnitInterface
{
    /**
     * @return int
     */
    public function getAttack(): int;

    /**
     * @return int
     */
    public function getCurrentHP(): int;

    /**
     * @return int
     */
    public function getProtection(): int;

    /**
     * @return int
     */
    public function getLvl(): int;
}
