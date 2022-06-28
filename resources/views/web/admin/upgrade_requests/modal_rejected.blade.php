<div class="modal" id="reject_upgrade_request{{$upgrade_request->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">reason rejected </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body">
                        
                <form action="{{route('upgrade_requests.rejected',$upgrade_request->id)}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field()}}

                    <div class="form-group">
                        <textarea   class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper"
                        name="rejected_reason" required placeholder="reject reson">{{$upgrade_request->rejected_reason}}</textarea>
                     </div>
                

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">تاكيد</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                    </div>
                </form>
            </div>


        </div>
    </div>
</div>
