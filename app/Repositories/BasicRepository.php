<?php

namespace App\Repositories;

use App\Repositories\Interfaces\RepositoryInterface;

class BasicRepository implements RepositoryInterface
{
    protected $model;

    public function get($condition = null)
    {
        return $this->model->where($condition);
    }

    public function create($requestData)
    {
        return $this->model->create($requestData);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function update($data)
    {
        $data->save();
    }

    public function delete($data)
    {
        $data->delete();
    }
}
