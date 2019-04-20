<?php
/**
 * Copyright © 2018 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */

namespace App\Http\Controllers\Api\Services\article;

use App\Article;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Database\Eloquent\Model;

/**
 * Class ArticleCreateService
 * @package App\Http\Controllers\Api\Services\article
 */
class ArticleCreateService
{
    /**
     * @var array
     */
    public $errors;

    /**
     * This method creates new Article model.
     *
     * @param array $data - associative array of Article model attributes
     * @return Model|Article|null
     */
    public function run(array $data)
    {
        /** @var \Illuminate\Contracts\Validation\Validator $validator */
        $validator = Validator::make($data, Article::$createRules);

        if ($validator->fails()) {
            $this->errors = $validator->errors();
            return null;
        }

        return \Auth::user()->articles()->create($data);
    }
}
