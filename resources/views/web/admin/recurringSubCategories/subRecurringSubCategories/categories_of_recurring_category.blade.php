<div class="modal" id="modaldemo2{{ $recurringSubCategory->id }}">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Categories</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
                <div class="modal-body">

                    <ul id="tree2" >


                        @foreach ($parentCategories as $category)
                            <li>
                                    <input id="last_level_category" type="checkbox" class="m-2" disabled @if( in_array($category->id, json_decode($recurringSubCategory->categories->pluck('id'))) ) checked @endif >

                                    <a href="#" >{{$category->name}}</a>
                                    @if ( $category->childs()->count()  )
                                            @include('web.admin.recurringSubCategories.subRecurringSubCategories.tree_to_categories_of_recurring_category', ['recurringSubCategory' => $recurringSubCategory, 'categories'   => $category->childs()])
                                    @endif
                                
                            </li>
                        @endforeach

                    </ul>

                </div>

        </div>
    </div>
</div>