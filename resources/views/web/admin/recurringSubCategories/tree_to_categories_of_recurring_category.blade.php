 

<ul>
    @foreach($categories->get() as $category)



    
    <li>
        
            <input id="last_level_category" disabled type="checkbox"  class="m-2" @if( in_array($category->id, json_decode($recurringSubCategory->categories->pluck('id'))) ) checked @endif>

            <a href="#">{{$category->name}}</a>

            

            @if ( $category->childs()->count()  )
                
                    @include('web.admin.recurringSubCategories.tree_to_categories_of_recurring_category', ['categories'   => $category->childs() ])
            @endif

        </li>
    @endforeach
   
</ul>






