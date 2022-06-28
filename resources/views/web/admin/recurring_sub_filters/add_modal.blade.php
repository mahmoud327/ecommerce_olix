<div class="modal" id="modaldemo8">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Add New Recurring Sub Filters</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('recurring_sub_filters.store') }}" method="post">
                    {{ csrf_field() }}

                    <input type="hidden" name="recurring_filter_id" value="{{$recurring_filter_id}}">
                    
                    <div class="form-group">
                        <input type="text" class="form-control" id="name_en" name="name_en" placeholder="Recurring Sub Filters Name in Engilsh">
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" id="name_ar" name="name_ar" placeholder="Recurring Sub Filters Name in Arabic">
                    </div>
                    

                    <div class="form-group">
                        <h4 class="form-section"><i class="ft-home"></i> {{ trans('lang.image') }}</h4>

                        <div id="dpz-multiple-files" class="dropzone dropzone-area">
                            <div class="dz-message">  {{ trans('lang.uploads') }} </div>
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