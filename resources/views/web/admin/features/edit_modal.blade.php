    <!-- edit -->
    <div class="modal fade" id="exampleModal2{{$feature->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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

                    <form action="{{route('features.update', $feature->id )}}" method="post" autocomplete="off">
                        {{ method_field('patch') }}
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="hidden" name="id" id="id" value="">
                            <label for="recipient-name" class="col-form-label">feature  name English:</label>
                            <input class="form-control" name="name_en" id="name" type="text" value="{{ $feature->getTranslation('name', 'en') }}">


                            
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="id" id="id" value="">
                            <label for="recipient-name" class="col-form-label">feature  name Arabic:</label>
                            <input class="form-control" name="name_ar" id="name" type="text" value="{{ $feature->getTranslation('name', 'ar') }}">  
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