<?php
/**
 * Copyright © 2019 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Hero;
use App\Services\Api\hero\InitHeroService;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class HeroController
 * @package App\Http\Controllers\Api\v1
 */
class HeroController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        $heroes = Hero::where('user_id', Auth::user()->id)->get();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'models' => $heroes,
        ], 200);
    }

    /**
     * @param Request $request
     * @param InitHeroService $createService
     * @return JsonResponse
     */
    public function store(Request $request, InitHeroService $createService)
    {
        $hero = $createService->run($request->all());
        if (!$hero) {
            return response()->json(['errors' => $createService->getErrors()], 422);
        }

        return response()->json([
            'code' => 201,
            'status' => 'success',
            'model' => $hero,
        ], 201);
    }
}
