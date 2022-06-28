    <!-- edit -->
    <div class="modal fade" id="exampleModal2{{$sub_filter->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ trans('lang.edit_sub_filter') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="{{route('sub_filters.update', $sub_filter->id )}}" method="post" autocomplete="off" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" name="name_en" placeholder="sub_filter name in English" value={{ $sub_filter->getTranslation('name', 'en') }}>
                        </div>
    
    
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" name="name_ar" placeholder="sub_filter name in Arabic" value={{ $sub_filter->getTranslation('name', 'ar') }}>
                        </div>


                        <div class="form-group" id="image" >
                            <div class="custom-file">
                                <input class="custom-file-input" name="image" value="{{$sub_filter->image}}" type="file"> <label class="custom-file-label" for="customFile">Choose image</label>
                            </div>
                        </div>
                        <br>
                        
                        <div class="form-group" id="image_edit">
                            
                              <img style="width: 80px;height:60px"  src="{{env('AWS_S3_URL').'/uploads/SubFilters/'.$sub_filter->image}}" alt="sub_filter-image">
                           
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