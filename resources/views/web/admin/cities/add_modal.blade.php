<div class="modal" id="modaldemo8">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Add New Governorate</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('cities.store') }}" method="post">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name_en" placeholder="city type name in English">
                    </div>


                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name_ar" placeholder="city type name in Arabic">
                    </div>
                    @inject('governorates', 'App\Models\Governorate')
                    <div class="form-group">
                        <select name="governorate_id" class="form-control">
                            <option value="" disabled selected>Select a governorate</option>
                            @foreach ($governorates->all() as $governorate)
                                
                                <option value="{{$governorate->id}}"> {{$governorate->name}} </option>
                            @endforeach

                        </select>
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