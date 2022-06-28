<div class="modal" id="upgrade{{$user->id}}">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo" style="margin-left:50%">
            <div class="modal-header">
                <h6 class="modal-title text-center">{{trans('lang.upgrade')}}</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user_upgrade',$user->id) }}" method="post">
                    {{ csrf_field() }}

                    

                    @inject('accounts','App\Models\Account')

                                        
                    <ul id="tree2" >

                        @foreach ($accounts->get() as $account)
                        
                            <li id="account">
                                
                                <a href="#">{{$account->name}}</a>
                                
                                <ul>
                                    @foreach ($account->subAccounts()->get() as $sub_account)
                            
                                        <li id="sub_account" >
                                            
                                            <input id="sub_account" @if ( $sub_account->id == $personal_id) checked  onclick="return false;" class="personal" @endif  type="checkbox" style="margin:3px"  name="sub_account[]" @if(in_array( $sub_account->id, json_decode( $user->subAccounts->pluck('id') )  ) ) ) checked   @endif  value="{{$sub_account->id}}" >{{$sub_account->name}}
                                            
                                        </li>

                                    @endforeach
                                </ul>
                            </li>
                        @endforeach

                    </ul>


                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">تاكيد</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Basic modal -->