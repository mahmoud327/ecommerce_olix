<div class="modal" id="modaldemo8">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Add New Sub Filter</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('sub_filters.store', $filter_id) }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name_en" placeholder="sub filter name in English">
                    </div>


                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name_ar" placeholder="sub_ ilter name in Arabic">
                    </div>

                    <br>
                    <div class="form-group">
                        <h4 class="form-section"><i class="ft-home"></i> {{ trans('lang.image') }}</h4>

                        <div class="custom-file">
                                    <input class="custom-file-input" name="image" type="file"> <label class="custom-file-label" for="customFile">Choose image</label>
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