<?php

namespace App\Media;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Model;


trait HasMedia
{

    public  $disk_name = "public";
    public function getDiskName(): string
    {
        return $this->disk_name ?? config('filesystems.default');
    }

    /**
     * Define the polymorphic relationship.
     */
    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'model');
    }

    /**
     * Add media to the model and upload it to the specified disk.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $collectionName
     * @param array $attributes
     * @return void
     */
    public function addMedia($file, string $collectionName, array $attributes = []): void
    {
        if (!$this->exists) {
            throw new \Exception("Cannot attach media to an unsaved model instance.");
        }

        try {

            $existingMedia = $this->media()->where('collection_name', $collectionName)->first();

            // Delete the old file if it exists
            if ($existingMedia && Storage::disk($this->getDiskName())->exists($existingMedia->file_path)) {
                Storage::disk($this->getDiskName())->delete($existingMedia->file_path);
            }

            // Store the file and get the file path
            $filePath = $file->store('media', $this->disk_name);


            $this->media()->updateOrCreate(
                [
                    'collection_name' => $collectionName,
                    'model_id' => $this->id,
                    'model_type' => static::class,
                ],
                array_merge($attributes, [
                    'file_path' => $filePath,
                    'file_type' => $file->getClientMimeType(),
                ])
            );
        } catch (\Exception $e) {
            throw new \Exception("Media upload failed: " . $e->getMessage());
        }
    }

    /**
     * Retrieve media items for the model.
     *
     * @param string|null $collectionName
     * @return array
     */
    public function getMedia(string $collectionName = null): array
    {
        $query = $this->media();

        if ($collectionName) {
            $query->where('collection_name', $collectionName);
        }
        return   $query->get()->toArray();
    }

    /**
     * Retrieve the URL of the first media item for the given collection.
     *
     * @param string|null $collectionName
     * @return string|null
     */
    public function getUrl($collectionName = null)
    {
        try {
            $query = $this->media();
            if ($collectionName) {
                $query->where('collection_name', $collectionName);
            }
            $media = $query->select('file_path')->get()->map(function ($media) {
                return [
                    'url' => Storage::disk($this->disk_name)->url($media->file_path),
                ];
            })->toArray();

            return $media ?? [];
        } catch (\Exception $exception) {
            throw new \Exception("Failed to retrieve media URL: " . $exception->getMessage());
        }
    }



    /**
     * Delete media from the model.
     *
     * @param int $mediaId
     * @return void
     */
    public function deleteMedia(int $mediaId): void
    {
        $media = $this->media()->findOrFail($mediaId);

        Storage::disk($this->disk_name)->delete($media->file_path);

        $media->delete();
    }

    protected static function booted()
    {
        static::deleting(function ($model) {
            $model->media->each(function ($media) {
                $media->delete();
            });
        });
    }
}
