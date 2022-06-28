<ul>

    @foreach($categories->get() as $category)

    <li>
        @if(!in_array( $category->id,$re_ids ))
        
            @if ($category->view->id == $last_level_id  )
    
            <input class="last_level_category" type="checkbox" name="last_categories[]" value="{{$category->id}}" class="m-2" 
            
            @isset($categories_id)
                @if( in_array( $category->id, json_decode( $categories_id )) ) checked  @endif
            @endisset
            >
    
            @else
            <input class="category" type="checkbox" class="m-2">
    
            @endif
            <a href="#" @if ( $category->view->id == $last_level_id  ) style="background-color:#229dff;color:#FFF;padding: 0px 10px;" @endif>{{$category->name}}</a>
    
                
    
                @if ( $category->childs()->count() )
                    @if ( isset($categories_id) )
                    
                    
                         @include('web.admin.recurring_filters.tree_category', ['categories'   => $category->childs(), 'last_level_id' => $last_level_id, 'categories_id' => $categories_id   ])
                     @else
                     
                         @include('web.admin.recurring_filters.tree_category', ['categories'   => $category->childs(), 'last_level_id' => $last_level_id ])
                    @endif
                @endif
           @endif
            

        </li>

    @endforeach

</ul>






