<ul>

    @foreach($categories->get() as $category)

    <li>
        @if ($category->view->name == 'last_level' )

        <input id="last_level_category" type="checkbox" name="categories[]" value="{{$category->id}}" @if(in_array( $sub_account->id, json_decode( $category->subAccounts->pluck('id') ) )) checked @endif class="m-2" @isset($categories_id)
        @if( in_array( $category->id, json_decode( $categories_id )) ) checked @endif
        @endisset>

        @else
        <input id="category" type="checkbox" class="m-2" name="categories[]" value="{{$category->id}}" @if(in_array( $sub_account->id, json_decode( $category->subAccounts->pluck('id') ) )) checked @endif>

        @endif
        <a href="#" @if ( $category->view->name == 'last_level' ) style="background-color:#229dff;color:#FFF;padding: 0px 10px;"@endif>{{$category->name}}</a>

            

            @if ( $category->childs()->count() )
                @include('web.admin.sub_accounts.tree_category', ['categories'   => $category->childs() ])
            @endif

        </li>

    @endforeach

</ul>






