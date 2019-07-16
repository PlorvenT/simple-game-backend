<?php
/**
 * Copyright © 2019 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */

namespace App\Services\Api\hero;

use App\Models\Hero;
use App\Services\ModelService;
use Illuminate\Support\Facades\Validator;

/**
 * Class InitHeroService
 * @package App\Services\Api\hero
 */
class InitHeroService extends ModelService
{
    public function run($data)
    {
        $data = array_merge($data, $this->getDefaultValues());
        /** @var \Illuminate\Contracts\Validation\Validator $validator */
        $validator = Validator::make($data, Hero::getCreateRules());

        if ($validator->fails()) {
            $this->setErrors($validator->errors());
            return null;
        }
        $data = $this->initDefaultValue($data);

        return \Auth::user()->heroes()->create($data);
    }

    private function getDefaultValues()
    {
        return [
            'lvl' => Hero::DEFAULT_LVL,
            'experience' => 0,
        ];
    }

    /**
     * @param array $data
     * @return array
     */
    private function initDefaultValue(array $data): array
    {
        $heroType = $data['type'];

        $data['max_heatpoint'] = Hero::$defaultHp[$heroType];
        $data['current_heatpoint'] = Hero::$defaultHp[$heroType];
        $data['attack'] = Hero::$defaultAttack[$heroType];

        return $data;
    }
}
