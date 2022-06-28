    <!-- edit -->
    <div class="modal fade" id="exampleModal2{{$view->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit viwe</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="{{route('views.update',$view)}}" method="post" autocomplete="off" enctype="multipart/form-data">
                     @method('put')
                     @csrf

                    <div class="form-group">
                        <input type="text" class="form-control" name="name_en"  readonly value="{{$view->name}}" placeholder="English name ">
                    </div>
                    <div class="form-group">
                        <div class="custom-file">
                            <input class="custom-file-input" name="image" value="{{$view->image}}" type="file"> <label class="custom-file-label" for="customFile">Choose image</label>
                        </div>
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