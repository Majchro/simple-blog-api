<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    public Model $model;

    public function find(int $id): ?Model
    {
        return $this->model->find($id);
    }

    public function delete(int $id): int
    {
        return $this->model->where('id', $id)->delete();
    }
}
