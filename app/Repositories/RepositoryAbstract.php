<?php

namespace App\Repositories;

use App\Repositories\Contract\RepositoryInterface;
use Exception;
use Illuminate\Support\Arr;

abstract class RepositoryAbstract implements RepositoryInterface
{
    protected mixed $entity;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->entity = $this->resolveEntity();
    }

    public abstract function entity();

    public function all()
    {
        return $this->entity->get();
    }

    public function find($id)
    {
        return $this->entity->find($id);
    }

    public function findWhere(string $column, $operator = '=', $value = null)
    {
        return $this->entity->where($column, $operator, $value);
    }

    public function paginate(int $perPage = 10)
    {
        return $this->entity->paginate($perPage);
    }

    public function create(array $properties)
    {
        return $this->entity->create($properties);
    }

    public function update($id, array $properties)
    {
        return $this->find($id)->update($properties);
    }

    public function updateWhere($column, $operator = '=', $value = null, array $properties = [])
    {
        return $this->findWhere($column, $operator, $value)
            ->first()
            ->update($properties);
    }

    public function where(string $column, $operator = '=', $value = null): static
    {
        $this->entity->where($column, $operator, $value);

        return $this;
    }

    public function delete($id)
    {
        return $this->find($id)->delete();
    }

    public function withCriteria(...$criteria): static
    {
        $criteria = Arr::flatten($criteria);

        foreach ($criteria as $cr) {
            $this->entity = $cr->apply($this->entity);
        }

        return $this;
    }

    /**
     * @throws Exception
     */
    protected function resolveEntity()
    {
        if (!method_exists($this, 'entity')) {
            throw new Exception('Not found the entity');
        }

        return app()->make($this->entity());
    }
}
