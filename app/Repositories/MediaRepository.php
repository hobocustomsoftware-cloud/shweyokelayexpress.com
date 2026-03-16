<?php

namespace App\Repositories;

use App\Models\Media;
use App\Services\MediaService;
use App\Repositories\Interfaces\MediaRepositoryInterface;

class MediaRepository implements MediaRepositoryInterface
{
    /**
     * Retrieve all media records.
     *
     * @return \Illuminate\Database\Eloquent\Collection|Media[]
     */
    public function getAllMedia()
    {
        return Media::all();
    }

    /**
     * Create a new media record.
     *
     * @param array $data
     * @return
     */
    public function create($mediaFile, $type)
    {
        $mediaService = new MediaService();
        return $mediaService->storeMedia($mediaFile, $type);
    }

    /**
     * Update a media record.
     *
     * @param \Illuminate\Http\File $mediaFile
     * @param string $type
     * @param int $id
     * @return int
     */
    public function update($mediaFile, $type, $id)
    {
        dd($id);
        $media = Media::find($id);
        if (!$media) {
            return null;
        }
        $mediaService = new MediaService();
        return $mediaService->updateMedia($mediaFile, $type, $media);
    }

    public function getMediaById($id)
    {
        return Media::find($id);
    }
}
