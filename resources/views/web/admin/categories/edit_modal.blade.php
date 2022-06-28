<!-- edit -->
<div class="modal fade" id="exampleModal2{{$category->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width:130%">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Categories</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <div class="modal-body">
                <form action="{{route('categories.update' , $category)}}" method="post" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                     <div class="row">

                            <div class="col-sm-6">

                                <div class="form-group">
                                    <input type="text" class="form-control" name="name_ar" value="{{$category->getTranslation('name' , 'ar')}}" placeholder="Arabic name ">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="name_en" value="{{$category->getTranslation('name' , 'en')}}" placeholder="English name ">
                                </div> 
                                
                                <div class="form-group">
                                    <textarea class="form-control" name="description_ar" placeholder="Arabic description" rows="3">{{$category->getTranslation('description' , 'ar')}} </textarea>
                                </div>

                                <div class="form-group">
                                    <textarea class="form-control" name="description_en" placeholder="English description" rows="3">{{$category->getTranslation('description' , 'en')}} </textarea>
                                </div>

                                            
                                <div class="form-group">
                                    
                                    <select class="form-control select2" name="view_id" id="view_edit" >
                                        
                                    @if($category->view) 
                                        <option value="{{$category->view->id}}">{{$category->view->name}}</option>
                                    @else
                                        <option label="Views"></option> 
                                    @endif 
                                    
                                    @foreach($views as $view) 
                                        <option value="{{$view->id}}" @if( $category->view_id == $view->id) @endif >{{$view->name}}</option>
                                    @endforeach 
                                    </select>
                                </div>
                                

                    
                                <div class="form-group" id="image" >
                                    <div class="custom-file">
                                        <input class="custom-file-input" name="image" value="{{$category->image}}" type="file"> <label class="custom-file-label" for="customFile">Choose image</label>
                                    </div>
                                </div>
                                <br>
                                
                                <div class="form-group" id="image_edit">
                                    
                                      <img style="width: 80px;height:60px"  src="{{ env('AWS_S3_URL') . '/' .$category->image}}" alt="categories-image">
                                   
                                </div>

                            </div>

                            <div class="col-sm-6">
                                <label> Accounts: </label><br>


                                <input type="checkbox" id="check_all_accounts_edit" class="m-2"><span>All Accounts</span>

                                @inject('accounts','App\Models\Account')

                                <ul id="treeview1">
                                    {{-- {{ dd ( $category->subAccounts->pluck('id') ) }} --}}

                                    @foreach ($accounts->get() as $account)
                                    
                                        <li id="account"><input id="account_edit" @if ( $account->name == 'suiiz') checked  onclick="return false;" class="suiiz"  @endif type="checkbox"  style="margin:3px"><a href="#">{{$account->name}}</a>
                                            
                                            <ul>
                                                @foreach ($account->subAccounts()->get() as $sub_account)
                                        
                                                    <li id="sub_account_edit" >
                                                        <input id="sub_account_edit" @if ( $sub_account->name == 'suiiz' ) checked onclick="return false;" class="suiiz" @endif @if(in_array( $sub_account->id, json_decode( $category->subAccounts->pluck('id') )  ) ) ) checked   @endif   type="checkbox" style="margin:3px"  name="sub_account[]" value="{{$sub_account->id}}" class="m-2">{{$sub_account->name}}
                                                        
                                                    </li>

                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                                    
                            </div>


                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">تاكيد</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                            </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Basic modal -->
