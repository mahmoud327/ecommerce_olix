<?php

namespace App\Actions\Fixes;

use Illuminate\Support\Str;
use Lorisleiva\Actions\Concerns\AsAction;

class FixOldMedia
{
    use AsAction;

    /**
     * @var string
     */
    protected $model;

    /**
     * @var string
     */
    protected $collection;

    /**
     * @param string $model
     */
    public function parseParams(string $model, string $collection)
    {
        $this->model = $model;
        $this->collection = $collection;
    }

    /**
     * @param string $model
     * @param string $collection
     */
    public function handle(string $model, string $collection, $resourcesLimit = 20)
    {
        $this->parseParams($model, $collection);

        // load model resources
        $resources = $this->model::query()
                          ->whereHas('medias')
                          ->with('medias')
                          ->limit($resourcesLimit)
                          ->get();

        optional($resources)->each(function ($resource) {
            FixResourceOldMedia::dispatch($resource, $this->collection);
        });
    }
}
