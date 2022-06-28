<div class="modal" id="accept_upgrade_request{{$upgrade_request->id}}">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo  mr-5" style="width:150%">
            <div class="modal-header">
                <h6 class="modal-title">accept upgrade request</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{route('upgrade_requests.accepted',$upgrade_request->id)}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}

                       <div class="">
                                <label> accept upgrade request : </label><br>


                                @inject('accounts','App\Models\Account')

                                <ul id="treeview1">

                                    @foreach ($accounts->get() as $account)
                                    
                                        <li id="account">
                                            <a href="#">{{$account->name}}</a>
                                            
                                            <ul>
                                                @foreach ($account->subAccounts()->get() as $sub_account)
                                        
                                                    <li id="sub_account" >
                                                        
                                                        <input id="sub_account"  type="checkbox" style="margin:3px" @if( $personal_id == $sub_account->id ) checked  checked onclick="return false;" class="personal" @endif   name="sub_account[]" value="{{$sub_account->id}}" class="m-2">{{$sub_account->name}}
                                                        
                                                    </li>

                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                                    
                                <div class="col-sm-9 modal-footer">
                                    <button type="submit" class="btn btn-primary">تاكيد</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                                </div>
                       </div>

                  


                </form>
            </div>
        </div>
    </div>
</div>
    <!-- End Basic modal -->

