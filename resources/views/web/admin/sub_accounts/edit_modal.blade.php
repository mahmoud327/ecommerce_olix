    <!-- edit -->
    <div class="modal fade" id="exampleModal2{{$sub_account->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">edit sub account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="{{route('sub_accounts.update', $sub_account->id )}}" method="post" autocomplete="off">
                        {{ method_field('patch') }}
                        {{ csrf_field() }}
                        <div class="form-group">
                           <div class="form-group">
                                <input type="text" class="form-control" id="name" name="name" placeholder="sub account" value="{{ $sub_account->name }}">
                            </div>

                            @inject('accounts', 'App\Models\Account')
                            <label for="recipient-name" class="col-form-label">Parent Accounts:</label>
                            <select class="form-control" name="account_id">
                                <option>Selecte Account</option>

                                @foreach ($accounts->all() as $account)
                                    <option value="{{ $account->id }}" @if ($account->id == $sub_account->account_id) selected @endif>{{$account->name}} </option>
                                @endforeach
                            </select>
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