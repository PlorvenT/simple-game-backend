<?php
/**
 * Copyright © 2019 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace App\Components\fight;

use App\Components\experience\ExperienceUpdater;
use App\Models\Fight;
use App\Models\FightLogs;
use App\Components\awards\AwardFactoryInterface;

/**
 * Class FightProcessor
 * @package App\Components\fight
 */
class FightProcessor
{
    /**
     * @var int
     */
    public const ROUND_DELAY = 1;

    /**
     * @var int
     */
    public const MAX_ROUND_COUNT = 100;

    /**
     * @var Fight
     */
    private $fight;

    /**
     * @var AwardFactoryInterface
     */
    private $awardService;

    /**
     * FightProcessor constructor.
     * @param Fight $fight
     * @param AwardFactoryInterface $awardService
     */
    public function __construct(Fight $fight, AwardFactoryInterface $awardService)
    {
        $this->fight = $fight;
        $this->awardService = $awardService;
    }

    /**
     * Method emulate fight with delay and calculate awards after fight
     */
    public function process()
    {
        $this->runFight();

        $this->processAwards();

        $this->updateHero();
        $this->updateUser();

        $this->fight->save();
    }

    /**
     * This method emulates fight process with delay
     */
    public function runFight()
    {
        $hero = $this->fight->hero;
        $enemy = $this->fight->enemy;
        $currentHeroHp = $hero->current_heatpoint;
        $enemyHp = $enemy->getCurrentHP();

        //add count for exit if fight takes too long time
        $countRound = 0;
        while($currentHeroHp > 0 || $enemyHp > 0) {
            if ($countRound >= self::MAX_ROUND_COUNT) {
                $this->log('Lose: too much rounds.', FightLogs::TYPE_END);
                $this->fight->status = Fight::STATUS_LOSE_HERO;
                break;
            }

            //hero always beat first
            sleep(self::ROUND_DELAY);
            $beatHeroPower = $hero->getAttack();
            $enemyHp -= $beatHeroPower;
            $this->log(
                'Hero beat enemy for: '. $beatHeroPower . '. Enemy left hp: ' . $enemyHp . '.',
                FightLogs::TYPE_HERO_ATTACK_ENEMY
            );
            if ($enemyHp <= 0) {
                $this->log('Win - WOW you are great!', FightLogs::TYPE_END);
                $this->fight->status = Fight::STATUS_WIN_HERO;
                break;
            }

            //enemy beat
            sleep(self::ROUND_DELAY);
            $enemyBeatPower = $enemy->getAttack();
            $currentHeroHp -= $enemyBeatPower;
            $this->log(
                'Enemy beat hero for: '. $enemyBeatPower . '. Hero left hp: ' . $currentHeroHp . '.',
                FightLogs::TYPE_ENEMY_ATTACK_HERO
            );
            if ($currentHeroHp <= 0) {
                $this->log('Lose: end Hp.', FightLogs::TYPE_END);
                $this->fight->status = Fight::STATUS_LOSE_HERO;
                break;
            }
        }

        $this->fight->date_end = date('Y-m-d H:i:s');
    }

    /**
     * This method updates hero attributes
     */
    private function updateHero()
    {
        //update hero exp
        $experienceUpdater = new ExperienceUpdater();
        $experienceUpdater->update($this->fight->hero, $this->fight->experience_award);
    }

    /**
     * This method updates user's characteristic which depends of fight
     */
    private function updateUser()
    {
        //update user gold
        $this->fight->hero->user->updateBalance($this->fight->gold_award);
    }

    /**
     * This method do simple debug.
     *
     * @param string $msg
     * @param string $type
     *
     * @return bool
     */
    private function log($msg, $type)
    {
        $fightLog = new FightLogs();

        $fightLog->type = $type;
        $fightLog->fight_id = $this->fight->id;
        $fightLog->description = $msg;

        return $fightLog->save();
    }

    /**
     * This methods calculates and sets awards.
     */
    private function processAwards()
    {
        $awardService = $this->awardService;

        $this->fight->gold_award = $awardService->makeGoldCalculator()->calculate();
        $this->fight->experience_award = $awardService->makeExperienceCalculator()->calculate();
    }
}
