<?php

namespace App\Repositories;

use Illuminate\Support\Arr;

abstract class EloquentRepository implements RepositoryInterface
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     * @author tanmnt
     */
    protected $_model;

    /**
     * EloquentRepository constructor.
     * @author tanmnt
     */
    public function __construct()
    {
        $this->setModel();
    }

    /**
     * get model
     * @return string
     * @author tanmnt
     */
    abstract public function getModel();

    /**
     * Set model
     * @author tanmnt
     */
    public function setModel()
    {
        $this->_model = app()->make($this->getModel());
    }

    /**
     * Get All
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     * @author tanmnt
     */
    public function getAll()
    {
        return $this->_model->all();
    }

    /**
     * Get one
     * @param $id
     * @return mixed
     * @author tanmnt
     */
    public function find($id)
    {
        $result = $this->_model->find($id);

        return $result;
    }

    /**
     * Find relationship
     * @param $id
     * @param array $with
     * @return mixed
     * @author tanmnt
     */
    public function findWith($id, $with)
    {
        $result = $this->_model->with(Arr::wrap($with))->find($id);

        return $result;
    }

    /**
     * Create
     * @param array $attributes
     * @return mixed
     * @author tanmnt
     */
    public function create(array $attributes)
    {
        return $this->_model->create($attributes);
    }

    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return bool|mixed
     * @author tanmnt
     */
    public function update($id, array $attributes)
    {
        $result = $this->find($id);
        if ($result) {
            $result->update($attributes);
            return $result;
        }

        return false;
    }

    /**
     * Delete
     *
     * @param $id
     * @return bool
     * @author tanmnt
     */
    public function delete($id)
    {
        $result = $this->find($id);
        if ($result) {
            $result->delete();

            return true;
        }

        return false;
    }
}
