 

<ul>
    @foreach($categories->get() as $category)


            
            @if ($loop->first)

                <li>
                    <input id="check_all_subs" type="checkbox" class="m-2"> <span style="background: #00f3ff"> check all </span>

                </li>
                
            @endif 
        
    
    <li>
        
        @if ( $category->view->name != 'last_level' )
            <input id="last_level_category" type="checkbox" name="categories_list[]" value="{{$category->id}}" class="m-2" @isset($categories_id)
            @if( in_array( $category->id, json_decode( $categories_id )) ) checked @endif
            @endisset>

            <a href="#">{{$category->name}}</a>

            
            @if ( $category->childs()->count() )
                @include('web.admin.recurringSubCategories.tree_category', ['categories'   => $category->childs() ])
            @endif
        @endif

        </li>
    @endforeach
   
</ul>






