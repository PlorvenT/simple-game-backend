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

class HeroExistRule implements Rule
{
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
        $hero = Hero::where(['user_id' => $user->id, 'id' => $value])->first();

        return $hero ? true : false;
    }

    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function message()
    {
        return 'No such hero.';
    }
}
