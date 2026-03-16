<?php
namespace App\Repositories;

use Spatie\Permission\Models\Permission;
use App\Repositories\Interfaces\PermissionRepositoryInterface;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    protected $relations = [];
    public function __construct(Permission $model)
    {
        parent::__construct($model);
    }

    public function getList($relations = [])
    {
        return parent::getList($relations);
    }

    public function create(array $data)
    {
        return parent::create($data);
    }

    public function update($id, array $data)
    {
        return parent::update($id, $data);
    }

    public function delete($id)
    {
        return parent::delete($id);
    }

    public function getById($id)
    {
        return parent::getById($id);
    }
}
