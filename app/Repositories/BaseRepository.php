<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

abstract class BaseRepository
{
    protected Model $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get list of data
     * @Author: HeinHtetAung
     * @Date: 2025-07-07
     */
    public function getList(array $relations = []){
        return $this->model->newQuery()->with($relations)->orderBy('id', 'desc');
    }

    /**
     * Get data by id
     * @Author: HeinHtetAung
     * @Date: 2025-07-07
     * @param int $id
     * @return Model
     */
    public function getById(int $id){
        return $this->model->find($id);
    }

    /**
     * Create new data
     * @Author: HeinHtetAung
     * @Date: 2025-07-07
     * @param array $data
     * @return Model
     */
    public function create(array $data){
        return $this->model->create($data);
    }

    /**
     * Update data by id
     * @Author: HeinHtetAung
     * @Date: 2025-07-07
     * @param int $id
     * @param array $data
     * @return Model
     */
    public function update(int $id, array $data){
        return $this->model->find($id)->update($data);
    }

    /**
     * Delete data by id
     * @Author: HeinHtetAung
     * @Date: 2025-07-07
     * @param int $id
     * @return bool
     */
    public function delete(int $id){
        return $this->model->find($id)->delete();
    }
}
