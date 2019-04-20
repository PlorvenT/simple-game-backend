<?php
/**
 * Copyright © 2018 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */

namespace App\Http\Services\Api\comment;

use App\Comment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;

class CommentCreateService
{
    /**
     * @var array
     */
    public $errors;

    /**
     * This method creates new Comment model.
     *
     * @param array $data - associative array of Comment model attributes
     * @return Model|Comment|null
     */
    public function run(array $data)
    {
        /** @var \Illuminate\Contracts\Validation\Validator $validator */
        $validator = Validator::make($data, Comment::$createRules);

        if ($validator->fails()) {
            $this->errors = $validator->errors();
            return null;
        }

        return \Auth::user()->comments()->create($data);
    }
}