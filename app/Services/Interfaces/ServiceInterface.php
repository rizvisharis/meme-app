<?php

namespace App\Services\Interfaces;

interface ServiceInterface
{
    public function store($requestData);

    public function index($requestData);

    public function update($data);

    public function delete($id);
}
