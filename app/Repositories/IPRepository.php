<?php

namespace App\Repositories;

use App\Http\Interfaces\IPRepositoryInterface;
use App\Models\IP;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class IPRepository implements IPRepositoryInterface
{
    protected $model;

    public function __construct()
    {
        $this->model = new IP();
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    public function find(int $id, array $with = [], array $params = []): ?Model
    {
        return $this->model->with($with)->findOrFail($id);
    }

    public function findWithTrash(int $id): ?Model
    {
        return $this->model::query()->withTrashed()->find($id);
    }

    public function delete(int $id)
    {
        return $this->model::query()->find($id)->delete();
    }

    public function update(int $id, array $attributes): Model
    {
        $model = $this->find($id);
        $model->update($attributes);
        return $model;
    }
}
