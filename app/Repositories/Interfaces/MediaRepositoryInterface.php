<?php
namespace App\Repositories\Interfaces;

interface MediaRepositoryInterface
{
    public function getAllMedia();
    public function create($mediaFile, $type);
    public function update($mediaFile, $type, $id);
    public function getMediaById($id);
}