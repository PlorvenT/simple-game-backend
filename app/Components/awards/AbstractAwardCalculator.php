<?php
/**
 * Copyright © 2019 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace App\Components\awards;

use App\Models\Fight;

/**
 * Class AbstractAwardCalculator
 * @package App\Components\awards
 */
abstract class AbstractAwardCalculator
{
    /**
     * @var Fight
     */
    protected $fight;

    /**
     * AbstractAwardCalculator constructor.
     * @param Fight $fight
     */
    public function __construct(Fight $fight)
    {
        $this->fight = $fight;
    }
}
