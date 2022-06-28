<ul>

    @foreach($recurring_categories->get() as $recurring_category)

    <li>
        @if ($recurring_category->view->name == 'last_level' )

        <input class="last_level_recurring_category" type="checkbox" name="last_recurring_categories[]" value="{{$recurring_category->id}}" class="m-2" @isset($recurring_categories_id)
        @if( in_array( $recurring_category->id, json_decode( $recurring_categories_id )) ) checked @endif
        @endisset>

        @else
        <input class="recurring_category" type="checkbox" class="m-2">

        @endif
        <a href="#" @if ( $recurring_category->view->name == 'last_level' ) style="background-color:#229dff;color:#FFF;padding: 0px 10px;"@endif>{{$recurring_category->name}}</a>

        @if ( $recurring_category->recurringChilds()->count()  )
            
                @isset($recurring_categories_id)

                    @include('web.admin.recurring_filters.tree_recurring_category', ['recurring_categories'   => $recurring_category->recurringChilds(), 'recurring_categories_id' => $recurring_categories_id  ])

                @else
                
                    @include('web.admin.recurring_filters.tree_recurring_category', ['recurring_categories'   => $recurring_category->recurringChilds()])

                @endisset

 

        @endif

           

            

        </li>

    @endforeach

</ul>






