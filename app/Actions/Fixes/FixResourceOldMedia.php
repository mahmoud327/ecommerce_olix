<?php

namespace App\Actions\Fixes;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Lorisleiva\Actions\Concerns\AsAction;

class FixResourceOldMedia
{
    use AsAction;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $resource;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $collection;

    /**
     * @param Model  $resource
     * @param string $collection
     */
    public function parseParams(Model $resource, string $collection)
    {
        $this->resource = $resource;
        $this->collection = $collection;
        $this->path = Str::snake(Str::plural(class_basename($this->resource)));
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $resource
     * @param string                              $collection
     */
    public function handle(Model $resource, string $collection)
    {
        $this->parseParams($resource, $collection);

        $medias = $this->resource->medias()->get();
        foreach ($medias as $media) {
            AddMediaFromOld::dispatch($resource, $media, $this->collection);
        }
    }
}
