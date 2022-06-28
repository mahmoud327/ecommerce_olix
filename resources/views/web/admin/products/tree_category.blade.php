<ul>

    @foreach($categories->get() as $category)

    <li>
        @if ($category->view->name == 'last_level' )

        <input id="last_level_category" type="radio" name="last_categories" value="{{$category->id}}" class="m-2" @isset($category_id)
        @if( $category->id ==  $category_id) checked @endif
    @endisset>


        @endif
        <a href="#" @if ( $category->view->name == 'last_level') style="background-color:#229dff;color:#FFF;padding: 0px 10px;"@endif>{{$category->name}}</a>

            

            @if ( $category->childs()->count() )
            @include('web.admin.products.tree_category', ['categories'   => $category->childs()])
            @endif

        </li>

    @endforeach

</ul>