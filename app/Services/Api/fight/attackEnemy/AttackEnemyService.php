<?php
/**
 * Copyright © 2019 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace App\Services\Api\fight\attackEnemy;

use App\Jobs\ProcessFight;
use App\Models\Enemy;
use App\Models\Fight;
use App\Models\Hero;
use App\Rules\attackEnemy\EnemyAvailableRule;
use App\Rules\attackEnemy\EnemyExistRule;
use App\Rules\attackEnemy\HeroAvailableRule;
use App\Rules\hero\HeroExistRule;
use App\Services\ModelService;
use App\User;
use Illuminate\Support\Facades\Validator;

class AttackEnemyService extends ModelService
{
    /**
     * @inheritDoc
     */
    public function run($data)
    {
        /** @var \Illuminate\Contracts\Validation\Validator $validator */
        $validator = Validator::make($data, [
            'hero_id' => ['required' , 'integer', new HeroExistRule(), new HeroAvailableRule()],
            'enemy_id' => ['required' , 'integer', new EnemyExistRule(), new EnemyAvailableRule()],
        ]);

        if ($validator->fails()) {
            $this->setErrors($validator->errors());
            return null;
        }

        /** @var Hero $hero */
        $hero = Hero::findOrFail($data['hero_id']);
        /** @var Enemy $enemy */
        $enemy = Enemy::findOrFail($data['enemy_id']);

        $result = $this->getResult($hero, $enemy);
        return $result;
    }

    /**
     * This method processing fight with enemy result.
     *
     * @param Hero $hero
     * @param Enemy $enemy
     * @return array
     */
    private function getResult(Hero $hero, Enemy $enemy)
    {
        /** @var User $user */
        $user = auth()->user();

        $fight = $this->createFight($hero, $enemy);
        //add fight to queue
        ProcessFight::dispatch($fight);

        $fight->hero;
        $fight->enemy;

        return ['balance' => $user->gold_balance, 'fight' => $fight];
    }

    /**
     * This method creates fight and add runs it in queue
     *
     * @param Hero $hero
     * @param Enemy $enemy
     * @return Fight
     */
    private function createFight(Hero $hero, Enemy $enemy)
    {
        $fight = new Fight();
        $fight->hero_id = $hero->id;
        $fight->enemy_id = $enemy->id;
        $fight->save();

        return $fight;
    }
}
