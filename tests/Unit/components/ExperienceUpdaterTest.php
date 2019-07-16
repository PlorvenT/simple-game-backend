<?php
/**
 * Copyright © 2019 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace Tests\Unit\components;

use App\Components\experience\ExperienceUpdater;
use App\Models\Hero;
use Tests\TestCase;

/**
 * Class ExperienceUpdaterTest
 * @package Tests\Unit\components
 */
class ExperienceUpdaterTest extends TestCase
{
    /**
     * @var ExperienceUpdater
     */
    private $expUpdateService;

    public function setUp(): void
    {
        parent::setUp();

        $this->expUpdateService = new ExperienceUpdater();
    }

    public function testBuildExpGreed()
    {
        $expectedGreed = [
            1 => 100,
            2 => 400,
            3 => 900,
            4 => 1600,
            5 => 2500,
            6 => 3600,
            7 => 4900,
            8 => 6400,
            9 => 8100,
            10 => 10000,
        ];
        $actualGreed = ExperienceUpdater::buildHeroLvlGreed();

        $this->assertEquals($expectedGreed, $actualGreed);
    }
//    public function testSuccessNotUpLvl()
//    {
//        $actualLvl = 1;
//        $expectedLvl = $this->expUpdateService->getHeroLvlByExp(ExperienceUpdater::buildHeroLvlGreed(), 99);
//        $this->assertEquals($actualLvl, $expectedLvl);
//
//        $actualLvl = 2;
//        $expectedLvl = $this->expUpdateService->getHeroLvlByExp(ExperienceUpdater::buildHeroLvlGreed(), 399);
//        $this->assertEquals($actualLvl, $expectedLvl);
//
//        $actualLvl = 3;
//        $expectedLvl = $this->expUpdateService->getHeroLvlByExp(ExperienceUpdater::buildHeroLvlGreed(), 899);
//        $this->assertEquals($actualLvl, $expectedLvl);
//
//        $actualLvl = 4;
//        $expectedLvl = $this->expUpdateService->getHeroLvlByExp(ExperienceUpdater::buildHeroLvlGreed(), 1599);
//        $this->assertEquals($actualLvl, $expectedLvl);
//    }


    public function testSuccessNotUpLvl()
    {
        foreach (ExperienceUpdater::buildHeroLvlGreed() as $key => $value)
        {
            $actualLvl = $key;

            $expectedLvl = $this->expUpdateService->getHeroLvlByExp(ExperienceUpdater::buildHeroLvlGreed(), $value - 1);
            $this->assertEquals($actualLvl, $expectedLvl);

            $expectedLvl = $this->expUpdateService->getHeroLvlByExp(ExperienceUpdater::buildHeroLvlGreed(), ($value - 100));
            $this->assertEquals($actualLvl, $expectedLvl);
        }
    }

    public function testNegativeExp()
    {
        $actualLvl = 1;
        $expectedLvl = $this->expUpdateService->getHeroLvlByExp(ExperienceUpdater::buildHeroLvlGreed(), -100);
        $this->assertEquals($actualLvl, $expectedLvl);
    }

    public function testZeroExp()
    {
        $actualLvl = 1;
        $expectedLvl = $this->expUpdateService->getHeroLvlByExp(ExperienceUpdater::buildHeroLvlGreed(), 0);
        $this->assertEquals($actualLvl, $expectedLvl);
    }

    public function testSuccessLvlUp()
    {
        foreach (ExperienceUpdater::buildHeroLvlGreed() as $key => $value)
        {
            $actualLvl = $key + 1;
            if ($actualLvl > Hero::MAX_LVL) {
                $actualLvl = Hero::MAX_LVL;
            }

            $expectedLvl = $this->expUpdateService->getHeroLvlByExp(ExperienceUpdater::buildHeroLvlGreed(), ($value + 1));
            $this->assertEquals($actualLvl, $expectedLvl);
        }
    }
}
