<?php
/**
 * Copyright © 2018 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */

namespace App\Http\Services\Api\article;

use App\Article;

/**
 * Class ArticleUpdateService
 * @package App\Http\Controllers\Api\Services\article
 */
class ArticleUpdateService
{
    /**
     * @param Article $article
     * @param array $data
     * @return Article
     */
    public function run(Article $article, array $data)
    {
        $article->update($data);

        return $article;
    }
}