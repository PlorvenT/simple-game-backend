<?php
/**
 * Copyright © 2019 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\MessageBag;

/**
 * Class ModelService
 * @package App\Services
 */
abstract class ModelService
{
    /**
     * @var MessageBag|null
     */
    private $errors;

    /**
     * @return MessageBag|null
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param MessageBag|null $errors
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }

    /**
     * This method run main service calculation.
     *
     * @param $data
     * @return mixed
     */
    abstract public function run($data);
}
