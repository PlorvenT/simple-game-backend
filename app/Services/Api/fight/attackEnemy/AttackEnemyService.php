<?php
/**
 * Copyright © 2019 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace App\Services\Api\fight\attackEnemy;

use App\Components\experience\ExperienceUpdater;
use App\Components\fight\FightInterface;
use App\Models\Enemy;
use App\Models\Hero;
use App\Rules\hero\EnemyAvailableRule;
use App\Rules\hero\EnemyExistRule;
use App\Rules\hero\HeroExistRule;
use App\Services\ModelService;
use App\User;
use Illuminate\Support\Facades\Validator;

class AttackEnemyService extends ModelService
{
    /**
     * @var FightInterface
     */
    private $fightService;

    /**
     * @var ExperienceUpdater
     */
    private $experienceUpdater;

    public function __construct(FightInterface $fightService, ExperienceUpdater $experienceUpdater)
    {
        $this->fightService = $fightService;
        $this->experienceUpdater = $experienceUpdater;
    }

    /**
     * @inheritDoc
     */
    public function run($data)
    {
        /** @var \Illuminate\Contracts\Validation\Validator $validator */
        $validator = Validator::make($data, [
            'hero_id' => ['required' , 'integer', new HeroExistRule()],
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
        //TODO: Need refactor, create fight add to queue for run and return fight model.
        /** @var User $user */
        $user = auth()->user();

        $fightResult = $this->fightService
            ->setFighters($hero, $enemy)
            ->process()
            ->processAward();

        if ($fightResult->isHeroWin()) {
            //update hero exp
            $hero = $this->experienceUpdater->update($hero, $fightResult->getExpAward());

            //update user gold_balance
            $user->updateBalance($fightResult->getGoldAward());

            return [
                'win' => true,
                'receivedGold' => $fightResult->getGoldAward(),
                'receivedExp' => $fightResult->getExpAward(),
                'fightTime' => time(),
                'hero' => $hero,
                'enemy' => $enemy,
                'balance' => $user->gold_balance,
            ];
        }

        return [
            'win' => false,
            'receivedGold' => 0,
            'receivedExp' => 0,
            'fightTime' => time(),
            'hero' => $hero,
            'enemy' => $enemy,
            'balance' => $user->gold_balance,
        ];
    }
}
