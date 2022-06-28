<div class="modal" id="modaldemo8">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Add New Filter</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('filters.store', $category_id) }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name_en" placeholder="filter name in English">
                    </div>


                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name_ar" placeholder="filter name in Arabic">
                    </div>

                    <div class="form-group col-lg-12 create">
                        <label> Accounts: </label><br>


                        <input type="checkbox" id="check_all_accounts" class="m-2"><span>All Accounts</span>

                        <ul id="treeview1">

                            @foreach ($accounts as $account)
                            
                                <li id="account"><input id="account" @if ( $account->name == 'suiiz') checked  onclick="return false;" class="suiiz"  @endif type="checkbox"  style="margin:3px"><a href="#">{{$account->name}}</a>
                                    
                                    <ul>
                                        @foreach ($account->subAccounts()->get() as $sub_account)
                                
                                            <li id="sub_account" >
                                                
                                                <input id="sub_account" @if ( $sub_account->name == 'suiiz') checked  onclick="return false;" class="suiiz" @endif  type="checkbox" style="margin:3px"  name="sub_account[]" value="{{$sub_account->id}}" class="m-2">{{$sub_account->name}}
                                                
                                            </li>

                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                        <br>

                        <div class="form-group">
                            <div class="custom-file">
                                    <input class="custom-file-input" name="image" type="file"> <label class="custom-file-label" for="customFile">Choose image</label>
                             </div>

                        </div>
                       

                    </div>


                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">تاكيد</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Basic modal -->