<?php
namespace App\Core\Repositories;

use Illuminate\Support\Facades\Log;

abstract class EloquentRepository implements RepositoryInterface {

    protected $_model;

    public function __construct() {
        $this->setModel();
    }

    abstract public function getModel();

    public function setModel(){
        $this->_model = app()->make(
            $this->getModel()
        );
    }

    /**
     * Get All
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return $this->_model->all();
    }

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $result = $this->_model->find($id);
        return $result;
    }

    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return $this->_model->create($attributes);
    }

    public function insert(array $attributes)
    {
        return $this->_model->insert($attributes);
    }
    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return bool|mixed
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
     */
    public function delete($id, $trash = true)
    {
        $result = $this->find($id);
        if($trash == true){
            // remove with trash

        }

        if ($result) {
            $result->delete();
            return true;
        }
        return false;
    }

    public function filter( $arrayFilter, $orderBy = null)
    {
        try {
            $query = $this->_model;
            if(isset($arrayFilter) && !empty($arrayFilter)) {
                return $orderBy ? $query->where($arrayFilter)->orderBy($orderBy[0], $orderBy[1])->get() : $query->where($arrayFilter)->get();
            }
            return false;
        }catch ( \Exception $e ){
            Log::error("Filter error in " . $this->_model);
            return false;
        }

    }

//    public function saveMany(array $data,$condition = null)
//    {
//        // TODO: Implement saveMany() method.
//        try {
//            $query = $this->_model;
//            if (isset($data) && !empty($data)) {
//                return $condition ? $query->where($condition)->saveMany($data) : $query->saveMany($data);
//            }
//        }catch ( \Exception $e ){
//            Log::error("Filter error in " . $this->_model);
//            return false;
//        }
//    }

    public function deleteMany($field,$conditions) {
        try {
            $query = $this->_model;
            return $query->whereIn($field,$conditions)->delete();
        }catch ( \Exception $e ){
            Log::error("Delete error in " . $this->_model);
            return false;
        }
    }
}
