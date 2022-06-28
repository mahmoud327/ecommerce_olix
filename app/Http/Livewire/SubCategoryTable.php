<?php

namespace App\Http\Livewire;

use App\models\Category;
use Livewire\Component;

class SubCategoryTable extends Component
{
    public $subCategories;
    public $category;
    public $last_view;
    public $views;
    public $parent;



    
    public function render(Category $category)
    {
        $subCategory = Category::where('parent_id', $category->id)->get();
        return view('livewire.sub-category-table', compact('subCategory'));
    }

    public function updatesubcategory($subCategory)
    {
        foreach ($subCategory as $cat) {
            Category::find($cat['value'])->update(['position'=>$cat['order']]);
        }
    }
}
