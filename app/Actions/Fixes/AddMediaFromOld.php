<?php

namespace App\Actions\Fixes;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Lorisleiva\Actions\Concerns\AsAction;

class AddMediaFromOld
{
    use AsAction;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $resource;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $media;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $collection;

    /**
     * @param Model $resource
     * @param Model $media
     * @param string $collection
     */
    public function parseParams(Model $resource, Model $media, string $collection)
    {
        $this->resource = $resource;
        $this->media = $media;
        $this->collection = $collection;
        $this->path = Str::snake(Str::plural(class_basename($this->resource)));
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $resource
     * @param \Illuminate\Database\Eloquent\Model $media
     * @param string                              $collection
     */
    public function handle(Model $resource, Model $media, string $collection)
    {
        $this->parseParams($resource, $media, $collection);

        Log::channel('dev')->info("Generating For Resource {$this->resource->id}");
        Log::channel('dev')->info("Generating {$media->path}");

        $fileName = explode('/', $media->path);
        $fileName = array_pop($fileName);

        $fileName = $this->resource->id . time() . uniqid() . '.' . $fileName;
        $newMedia = $this->resource->addMediaFromUrl(config('filesystems.disks.s3.url') . '/' . $media->path)
                             ->setName("{$this->path}/{$fileName}")
                             ->setFileName("{$this->path}/{$fileName}")
                             ->setOrder($media->position);

        if ($media->position == 1) {
            $newMedia->withCustomProperties(['isFeatured' => true]);
        }

        $newMedia->toMediaCollection($this->collection);

        $media->delete();
    }
}
