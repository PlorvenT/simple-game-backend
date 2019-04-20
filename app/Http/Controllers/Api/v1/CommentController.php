<?php
/**
 * Copyright © 2018 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */

namespace App\Http\Controllers\Api\v1;

use App\Article;
use App\Comment;
use App\Http\Controllers\Controller;
use Auth;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Services\comment\CommentUpdateService as UpdateService;
use App\Http\Controllers\Api\Services\comment\CommentCreateService as CreateService;
use App\Http\Controllers\Api\Services\DeleteService;

/**
 * Class CommentController
 * @package App\Http\Controllers\Api\v1
 */
class CommentController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        $articles = Comment::where('user_id', Auth::user()->id)->get();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'models' => $articles,
        ], 200);
    }

    /**
     * @param Comment $comment
     * @return JsonResponse
     */
    public function show(Comment $comment)
    {
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'model' => $comment,
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
     * @param Comment $comment
     * @param UpdateService $updateService
     * @return JsonResponse
     */
    public function update(Request $request, Comment $comment, UpdateService $updateService)
    {
        $comment = $updateService->run($comment, $request->all());

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'model' => $comment,
        ], 200);
    }

    /**
     * @param Comment $comment
     * @param DeleteService $deleteService
     * @return JsonResponse
     * @throws Exception
     */
    public function delete(Comment $comment, DeleteService $deleteService)
    {
        $deleteService->run($comment);

        return response()->json([
            'code' => 200,
            'status' => 'success',
        ], 200);
    }
}