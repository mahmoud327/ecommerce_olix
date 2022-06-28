<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\models\Category;

class CategoryTable extends Component
{
    public $categories;
    public $category;
    public $last_view;


    public $views;
    public function render()
    {
        $categorie=Category::get();
        return view('livewire.category-table', compact('categorie'));
    }

    public function updatecategory($categorie)
    {
        foreach ($categorie as $cat) {
            Category::find($cat['value'])->update(['position'=>$cat['order']]);
        }
    }
}
