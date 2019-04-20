<?php
/**
 * Copyright © 2018 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */

namespace App\Http\Controllers\Api\v1;

use App\Article;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

/**
 * Class ArticleController
 * @package App\Http\Controllers
 */
class ArticleController extends Controller
{
    /**
     * @return Article[]|Collection
     */
    public function index()
    {
        return Article::all();
    }

    /**
     * @param Article $article
     * @return Article|Article[]|Collection|Model|null
     */
    public function show(Article $article)
    {
        return Article::find($article);
    }

    /**
     * @param Request $request
     * @return Article|Model
     */
    public function store(Request $request)
    {
        $data = $request->all();
        /** @var \Illuminate\Contracts\Validation\Validator $validator */
        $validator = Validator::make($data, Article::$createRules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $article = \Auth::user()->articles()->create($data);

        return response()->json($article, 201);
    }

    /**
     * @param Request $request
     * @param Article $article
     * @return Article|Collection|Model
     */
    public function update(Request $request, Article $article)
    {
        $article->update($request->all());

        return response()->json($article, 200);
    }

    /**
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete(Article $article)
    {
        $article->delete();

        return response()->json(null, 204);
    }
}
