<?php
/**
 * Copyright © 2019 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace App\Jobs;

use App\Components\fight\AwardFactory;
use App\Components\fight\FightProcessor;
use App\Models\Fight;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * Class ProcessFight
 * @package App\Jobs
 */
class ProcessFight implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Fight
     */
    protected $fight;

    /**
     * Create a new job instance.
     *
     * @param Fight $fight
     * @return void
     */
    public function __construct(Fight $fight)
    {
        $this->fight = $fight;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $awardService = AwardFactory::make($this->fight);
        $fightProcessor = new FightProcessor($this->fight, $awardService);
        $fightProcessor->process();
    }
}
