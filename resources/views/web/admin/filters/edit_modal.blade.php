    <!-- edit -->
    <div class="modal fade" id="exampleModal2{{$filter->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ trans('lang.edit_filter') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="{{route('filters.update', $filter->id )}}" method="post" autocomplete="off" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" name="name_en" placeholder="filter name in English" value={{ $filter->getTranslation('name', 'en') }}>
                        </div>
    
    
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" name="name_ar" placeholder="filter name in Arabic" value={{ $filter->getTranslation('name', 'ar') }}>
                        </div>


                        <div class="form-group col-lg-12 edit">
                            <label> Accounts: </label><br>
    
    
                            <input type="checkbox" id="check_all_accounts" class="m-2"><span>All Accounts</span>
    
                            <ul id="tree3">
    
                                @foreach ($accounts as $account)
                                
                                    <li id="account"><input id="account" @if ( $account->name == 'suiiz') checked  onclick="return false;" class="suiiz"  @endif type="checkbox"  style="margin:3px"><a href="#">{{$account->name}}</a>
                                        
                                        <ul>
                                            @foreach ($account->subAccounts()->get() as $sub_account)
                                    
                                                <li id="sub_account" >
                                                    
                                                    <input id="sub_account" @if ( $sub_account->name == 'suiiz') checked  onclick="return false;" class="suiiz" @endif @if( in_array($sub_account->id, json_decode($filter->subAccounts()->pluck('sub_account_id') ) ) ) checked @endif  type="checkbox" style="margin:3px"  name="sub_account[]" value="{{$sub_account->id}}" class="m-2">{{$sub_account->name}}
                                                    
                                                </li>
    
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                            <br>
                            <div class="form-group" id="image" >
                                <div class="custom-file">
                                    <input class="custom-file-input" name="image" value="{{$filter->image}}" type="file"> <label class="custom-file-label" for="customFile">Choose image</label>
                                </div>
                            </div>
                            <br>
                            
                            <div class="form-group" id="image_edit">
                                
                                  <img style="width: 80px;height:60px"  src="{{env('AWS_S3_URL').'/uploads/Filters/'.$filter->image}}" alt="categories-image">
                               
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