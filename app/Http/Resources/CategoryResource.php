<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\View;
use URL;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        if ($this->is_all == 1) {
            $all = (object) array(
                'id'              => $this->id,
                'name'            => 'All',
                'description'     => 'Description to all',
                'view_name'       => 'last_level',
                'image'           => $this->image ? env('AWS_S3_URL').'/'.$this->image : env('AWS_S3_URL').'/uploads/avatar.png',
            );
        } else {
            $all = null;
        }
        
        
        
        if ($this->parent_id != 0) {
            $count = $this->products->count();
            $text3 = $this->parents->view_id == $baner_id ? $count . (config()->get("app.locale") == 'en' ? ' Category' : (($count > 10 || $count <= 2) ?' فئة ' : ' فئات ')): "" ;
        } else {
            $text3 = "";
        }
        

        $baner_id = View::where('name', 'banner')->first()->id;


        return [
                    'id'                        => $this->id,
                    'name'                      => $this->name,
                    'description'               => $this->description,
                    'image'                     => $this->image ? env('AWS_S3_URL').'/'.$this->image : env('AWS_S3_URL').'/uploads/avatar.png',
                    'text1'                     => (string) $this->text1,
                    'text2'                     => (string) $this->text2,
                    'text3'                     => (string)$text3,
                    'parent_id'                 => $this->parent_id,
                    'view_name'                 => $this->view->name,
                    'childs'                    =>  [ 'all' => $all , 'subs' => CategoryResource::collection($this->childrenRecursive)],
         ];
    }
}
