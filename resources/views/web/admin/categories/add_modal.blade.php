<div class="modal" id="modaldemo8">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo  mr-5" style="width:150%">
            <div class="modal-header">
                <h6 class="modal-title">Add New Category</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{route('categories.store')}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="row">
                          <div class="col-sm-6">

                                <div class="form-group">
                                    <input type="text" class="form-control" name="name_en"  value="{{old('name_en')}}"  placeholder="English name ">
                                </div> 

                                <div class="form-group">
                                    
                                    <textarea class="form-control" name="description_en"  rows="3" placeholder="English description">{{old('description_en') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control" name="name_ar"  value="{{old('name_ar')}}"  placeholder="Arabic name ">
                                </div>
                            
                                <div class="form-group">
                                    <textarea class="form-control" name="description_ar" placeholder="Arabic description" rows="3">{{old('description_ar') }}</textarea>
                                </div>
                        
                                <div class="form-group">
                                    <select class="form-control select2"  name="view_id"  id="view_add">
                                        <option label="Views"></option>
                                    @foreach($views as $view)

                                      <option value="{{$view->id}}"  {{ ( $view->name == $last_view) ? 'selected' :'' }} >{{$view->name}}</option>
                                      
                                    @endforeach 
                                    </select>
                                </div><!-- col-4 -->   
                                 
                         <div class="form-group">
                        <div class="custom-file">
                            <input class="custom-file-input" name="image" type="file"> <label class="custom-file-label" for="customFile">Choose image</label>
                        </div>
                   

                               </div>
                        
                           

                       </div>

                       <div class="col-sm-6">
                                <label> Accounts: </label><br>


                                <input type="checkbox" id="check_all_accounts" class="m-2"><span>All Accounts</span>

                                @inject('accounts','App\Models\Account')

                                <ul id="treeview1">

                                    @foreach ($accounts->get() as $account)
                                    
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

