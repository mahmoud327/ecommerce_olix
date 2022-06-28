<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Http\Resources\CategoryNameResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SaveSearcedResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $category = Category::find($this->category_id);
        if ($category->parents) {
            $path = $category->getParentsNames()->reverse()->push($category);
        } else {
            $path = Category::where('id', $this->category_id)->get();
        }

        return [
            'id'          => $this->id,
            'user_id'     => $this->user_id,
            'category_id' => $this->category_id,
            'path'        => CategoryNameResource::collection($path),

        ];
    }
}
