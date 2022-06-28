<div class="modal" id="modaldemo8">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Add New Filter Type</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('organization_types.store') }}" method="post">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name_en" placeholder="organization type name in English">
                    </div>


                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name_ar" placeholder="organization type name in Arabic">
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