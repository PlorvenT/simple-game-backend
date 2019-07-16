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
 * Class AbstractFight
 * @package App\Components\fight
 */
abstract class AbstractFight implements FightInterface
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
     * @var int
     */
    public const MAX_LVL_DIFFERENCE_FOR_EXP = 2;

    /**
     * @var int
     */
    public const EXP_FOR_ENEMY_MULTIPLIER = 10;

    /**
     * @var int
     */
    public const GOLD_FOR_ENEMY_MULTIPLIER = 20;

    /**
     * @var int
     */
    protected $goldAward;

    /**
     * @var int
     */
    protected $expAward;

    /**
     * @var Hero
     */
    protected $hero;

    /**
     * @var UnitInterface
     */
    protected $enemy;

    /**
     * @var bool
     */
    protected $isWin;

    /**
     * @var bool
     */
    public $debugMode = false;

    /**
     * @inheritDoc
     */
    public function setFighters(Hero $hero, UnitInterface $enemy): FightInterface
    {
        $this->hero = clone $hero;
        $this->enemy = $enemy;

        return $this;
    }

    /**
     * This method do simple debug.
     *
     * @param $msg
     */
    private function debug($msg)
    {
        if (!$this->debugMode){
            return;
        }

        $timeInfo = '[' . date('Y-m-d H:i:s') . ']: ';
        echo $timeInfo . $msg . PHP_EOL;
    }

    /**
     * This method processing fight and calculates who win.
     *
     * @return FightInterface
     */
    public function process(): FightInterface
    {
        $currentHeroHp = $this->hero->current_heatpoint;
        $enemyHp = $this->enemy->getCurrentHP();

        //add count for exit if fight takes too long time
        $countRound = 0;
        while($currentHeroHp > 0 || $enemyHp > 0) {
            if ($countRound >= self::MAX_ROUND_COUNT) {
                $this->isWin = false;
                $this->debug('Lose: too much rounds.');
                break;
            }

            //hero always beat first
            sleep(self::ROUND_DELAY);
            $beatHeroPower = $this->hero->getAttack();
            $enemyHp -= $beatHeroPower;
            $this->debug('Hero beat enemy for: '. $beatHeroPower . '. Enemy left hp: ' . $enemyHp . '.');
            if ($enemyHp <= 0) {
                $this->isWin = true;
                $this->debug('Win - WOW you are great!');
                break;
            }

            //enemy beat
            sleep(self::ROUND_DELAY);
            $enemyBeatPower = $this->enemy->getAttack();
            $currentHeroHp -= $enemyBeatPower;
            $this->debug('Enemy beat hero for: '. $enemyBeatPower . '. Hero left hp: ' . $currentHeroHp . '.');
            if ($currentHeroHp <= 0) {
                $this->isWin = false;
                $this->debug('Lose: end Hp.');
                break;
            }
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isHeroWin(): bool
    {
        return $this->isWin;
    }

    /**
     * @return int|null
     */
    public function getGoldAward(): ?int
    {
        return $this->goldAward;
    }

    /**
     * @return int|null
     */
    public function getExpAward(): ?int
    {
        return $this->expAward;
    }

    /**
     * This method calculates gold awards.
     *
     * @return int
     */
    abstract public function calculateGoldAward(): int;

    /**
     * This method calculates experience awards.
     *
     * @return int
     */
    abstract public function calculateExpAward(): int;

    /**
     * This method calculates awards that give after fight
     *
     * @return FightInterface
     */
    public function processAward(): FightInterface
    {
        //no need calculate if we lose
        if ($this->isWin) {
            $this->goldAward = $this->calculateGoldAward();
            $this->expAward = $this->calculateExpAward();
        } else {
            $this->goldAward = 0;
            $this->expAward = 0;
        }

        return $this;
    }
}
