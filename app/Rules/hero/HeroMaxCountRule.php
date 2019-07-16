<?php
/**
 * Copyright © 2019 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace App\Rules\hero;

use App\Models\Hero;
use App\User;
use Illuminate\Contracts\Validation\Rule;

/**
 * Class HeroMaxCountRule
 * @package App\Rules\hero
 */
class HeroMaxCountRule implements Rule
{
    public const MAX_COUNT = 3;

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        /** @var User $user */
        $user = auth()->user();

        $heroesCount = Hero::where(['user_id' => $user->id])->get()->count();

        return $heroesCount < self::MAX_COUNT;
    }

    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function message()
    {
        return 'The limit for hero is ' . self::MAX_COUNT  . '. You can delete you another heroes.';
    }
}
