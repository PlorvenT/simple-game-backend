<?php
/**
 * Copyright © 2018 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */

namespace App\Http\Controllers\Api\v1;

use App\Article;
use App\Http\Services\Api\article\ArticleCreateService as CreateService;
use App\Http\Services\Api\article\ArticleUpdateService as UpdateService;
use App\Http\Services\Api\DeleteService;
use Auth;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class ArticleController
 * @package App\Http\Controllers
 */
class ArticleController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        $articles = Article::where('user_id', Auth::user()->id)->get();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'models' => $articles,
        ], 200);
    }

    /**
     * @param Article $article
     * @return JsonResponse
     */
    public function show(Article $article)
    {
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'model' => $article->load('comments'),
        ], 200);
    }

    /**
     * @param Request $request
     * @param CreateService $createService
     * @return JsonResponse
     */
    public function store(Request $request, CreateService $createService)
    {
        $article = $createService->run($request->all());
        if (!$article) {
            return response()->json(['errors' => $createService->errors], 422);
        }

        return response()->json([
            'code' => 201,
            'status' => 'success',
            'model' => $article,
        ], 201);
    }

    /**
     * @param Request $request
     * @param Article $article
     * @param UpdateService $updateService
     * @return JsonResponse
     */
    public function update(Request $request, Article $article, UpdateService $updateService)
    {
        $article = $updateService->run($article, $request->all());

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'model' => $article,
        ], 200);
    }

    /**
     * @param Article $article
     * @param DeleteService $deleteService
     * @return JsonResponse
     * @throws Exception
     */
    public function delete(Article $article, DeleteService $deleteService)
    {
        $deleteService->run($article);

        return response()->json([
            'code' => 200,
            'status' => 'success',
        ], 200);
    }
}
