<?php


namespace App\Services\Api;


class BaseService
{
    /**
     * @var
     */
    protected $baseModel;


    /**
     * @param $model
     */
    protected function set_model($model)
    {
        $this->baseModel = $model->query();
    }
}
