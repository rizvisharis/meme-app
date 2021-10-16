<?php

namespace App\Repositories\Interfaces;

interface RepositoryInterface
{
    public function create($requestData);

    public function get($condition = null);

    public function find($id);

    public function update($data);

    public function delete($data);
}
