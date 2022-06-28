<?php

namespace App\Http\Resources;

use App\Models\View;
use Illuminate\Http\Resources\Json\JsonResource;

class ParentCategoryResource extends JsonResource
{

    /**
     * @param $request
     */
    public function toArray($request)
    {
        if ($this->parent_id) {
            $text3 = $this->parents->view_id == $this->view->id ? $this->products_count .
            (config()->get("app.locale") == 'en' ? ' Category' : (($this->products_count > 10 || $this->products_count <= 2) ? ' فئة ' : ' فئات ')) : null;

            $text1 = ($this->parents->view_id == $this->view->id && $this->products_count > 0) ? $this->products_min_price : null;
            $text2 = ($this->parents->view_id == $this->view->id && $this->products_count > 1) ? $this->products_max_price : null;
        }

        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'image'       => $this->image ? env('AWS_S3_URL') . '/' . $this->image : env('AWS_S3_URL') . '/uploads/avatar.png',
            'text1'       => $text1 ?? "",
            'text2'       => $text2 ?? "",
            'text3'       => $text3 ?? "",
            'parent_id'   => $this->parent_id,
            'view_name'   => $this->view->name,
        ];
    }
}
