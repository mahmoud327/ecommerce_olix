<ul>

    @foreach($categories->get() as $category)
    <li>
        <input id="last_level_category" type="checkbox" name="categories_list[]" value="{{$category->id}}" class="m-2" @isset($categories_id)
        @if( in_array( $category->id, json_decode( $categories_id )) ) checked @endif
        @endisset>

        <a href="#" @if ( $category->view->name != 'last_level' ) style="background-color:#229dff;color:#FFF;padding: 0px 10px;"@endif>{{$category->name}}</a>

            
            @if ( $category->childs()->count() )
                @include('web.admin.recurringSubCategories.subRecurringSubCategories.tree_category', ['categories'   => $category->childs() ])
            @endif

        </li>
    @endforeach
   
</ul>






