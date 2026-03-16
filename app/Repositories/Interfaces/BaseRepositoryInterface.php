<?php
namespace App\Repositories\Interfaces;

use Dotenv\Repository\RepositoryInterface;

interface BaseRepositoryInterface extends RepositoryInterface
{
    /**
     * Base for all repository
     * @Author: HeinHtetAung
     * @Date: 2025-07-07
     */
    public function getList();
    public function getById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
