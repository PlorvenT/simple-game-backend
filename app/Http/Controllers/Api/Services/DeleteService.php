<?php
/**
 * Copyright © 2018 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */

namespace App\Http\Controllers\Api\Services;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DeleteService
 * @package App\Http\Controllers\Api\Services
 */
class DeleteService
{
    /**
     * @param Model $model
     * @throws \Exception
     */
    public function run(Model $model)
    {
        $model->delete();
    }
}