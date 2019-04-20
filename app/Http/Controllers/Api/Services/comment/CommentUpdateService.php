<?php
/**
 * Copyright © 2018 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */

namespace App\Http\Controllers\Api\Services\comment;

use App\Comment;

/**
 * Class CommentUpdateService
 * @package App\Http\Controllers\Api\Services\comment
 */
class CommentUpdateService
{
    /**
     * @param Comment $comment
     * @param array $data
     * @return Comment
     */
    public function run(Comment $comment, array $data)
    {
        unset($data['article_id']);
        $comment->update($data);

        return $comment;
    }
}