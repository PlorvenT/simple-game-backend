<?php
/**
 * Copyright © 2019 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace App\Rules\attackEnemy;

use App\Models\Fight;
use Illuminate\Contracts\Validation\Rule;

/**
 * Class HeroAvailableRule
 * @package App\Rules\attackEnemy
 */
class HeroAvailableRule implements Rule
{
    /**
     * @var null|Fight
     */
    private $fight;

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $this->fight = Fight::where([
            ['hero_id', '=', $value],
            ['status', '=', Fight::STATUS_IN_PROGRESS],
        ])->first();

        return $this->fight ? false : true;
    }

    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function message()
    {
        return 'Hero is busy in fight: ' . $this->fight->id . '.';
    }
}
