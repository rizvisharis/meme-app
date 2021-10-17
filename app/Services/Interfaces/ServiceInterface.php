<?php

namespace App\Services\Interfaces;

interface ServiceInterface
{
    public function store($requestData);

    public function index($requestData);

    public function update($requestData, $id);

    public function delete($id);
}
