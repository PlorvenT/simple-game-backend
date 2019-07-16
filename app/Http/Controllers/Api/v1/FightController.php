<?php
/**
 * Copyright © 2019 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace App\Http\Controllers\Api\v1;

use App\Components\experience\ExperienceUpdater;
use App\Components\fight\FightService;
use App\Http\Controllers\Controller;
use App\Services\Api\fight\attackEnemy\AttackEnemyService;
use Illuminate\Http\Request;

/**
 * Class FightController
 * @package App\Http\Controllers\Api\v1
 */
class FightController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function attackEnemy(Request $request)
    {
        //TODO: added factory method for creating attack service. Maybe add "ban" column to user?
        $attackService = new AttackEnemyService(new FightService(), new ExperienceUpdater());
        $result = $attackService->run($request->all());

        if (!$result) {
            return response()->json([
                'code' => 422,
                'status' => 'success',
                'message' => 'Unprocessable Entity',
                'errors' => $attackService->getErrors()
            ], 422);
        }

        return response()->json([
            'code' => 201,
            'status' => 'success',
            'result' => $result,
        ], 201);
    }
}
