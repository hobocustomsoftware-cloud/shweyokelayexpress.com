<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Media;

class MediaService
{
    /**
     * Store a new media record.
     *
     * @param \Illuminate\Http\File $mediaFile
     * @param string $type
     * @return int
     */
    public function storeMedia($mediaFile, $type)
    {
        if (!$mediaFile->isValid()) {
            throw new \Exception('Invalid media file.');
        }

        try {
            DB::beginTransaction();
            $path = $mediaFile->store('images/' . $type, 'public_folder');
            $media = new Media();
            $media->path = $path;
            $media->type = $type;
            $media->mime_type = $mediaFile->getMimeType();
            $media->file_name = $mediaFile->getClientOriginalName();
            $media->file_size = $mediaFile->getSize();
            $media->save();
            DB::commit();
            return $media->id;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Failed to upload media: ' . $e->getMessage());
        } finally {
            DB::commit();
        }
    }

    /**
     * Update a media record.
     *
     * @param \Illuminate\Http\File $mediaFile
     * @param string $type
     * @return int
     */
    public function updateMedia($mediaFile, $type, $media)
    {
        try {
            DB::beginTransaction();
            if (Storage::disk('public_folder')->exists($media->path)) {
                Storage::disk('public_folder')->delete($media->path);
            }
            if (!is_string($mediaFile)) {
                dd('mediaFile is not a string');
                $path = $mediaFile->store('images/' . $type, 'public_folder');
                $media->mime_type = $mediaFile->getMimeType();
                $media->file_name = $mediaFile->getClientOriginalName();
                $media->file_size = $mediaFile->getSize();
            } else {
                $path = $mediaFile;
                dd('mediaFile is a string');
            }
            $media->path = $path;
            $media->type = $type;
            $media->save();
            DB::commit();
            return $media->id;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Failed to upload media: ' . $e->getMessage());
        } finally {
            DB::commit();
        }
    }
}
