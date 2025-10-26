<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Buscar todos os registros
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * Buscar por ID
     */
    public function find(int $id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * Buscar por UUID
     */
    public function findByUuid(string $uuid): ?Model
    {
        return $this->model->where('uuid_' . $this->getTableName(), $uuid)->first();
    }

    /**
     * Criar novo registro
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Atualizar registro
     */
    public function update(int $id, array $data): bool
    {
        $model = $this->find($id);
        if (!$model) {
            return false;
        }
        return $model->update($data);
    }

    /**
     * Deletar registro
     */
    public function delete(int $id): bool
    {
        $model = $this->find($id);
        if (!$model) {
            return false;
        }
        return $model->delete();
    }

    /**
     * Paginar resultados
     */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->paginate($perPage);
    }

    /**
     * Buscar com filtros
     */
    public function where(array $conditions): Collection
    {
        $query = $this->model->newQuery();
        
        foreach ($conditions as $field => $value) {
            if (is_array($value)) {
                $query->whereIn($field, $value);
            } else {
                $query->where($field, $value);
            }
        }
        
        return $query->get();
    }

    /**
     * Contar registros
     */
    public function count(array $conditions = []): int
    {
        $query = $this->model->newQuery();
        
        foreach ($conditions as $field => $value) {
            if (is_array($value)) {
                $query->whereIn($field, $value);
            } else {
                $query->where($field, $value);
            }
        }
        
        return $query->count();
    }

    /**
     * Buscar registros ativos
     */
    public function findActive(): Collection
    {
        return $this->model->where('ativo', true)->get();
    }

    /**
     * Obter nome da tabela
     */
    protected function getTableName(): string
    {
        return $this->model->getTable();
    }

    /**
     * Buscar com relacionamentos
     */
    public function with(array $relations): Collection
    {
        return $this->model->with($relations)->get();
    }

    /**
     * Buscar um registro com relacionamentos
     */
    public function findWith(int $id, array $relations): ?Model
    {
        return $this->model->with($relations)->find($id);
    }
}
