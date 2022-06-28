    <!-- edit -->
    <div class="modal fade" id="exampleModal2{{$sub_property->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">edit sub property</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="{{route('sub_properties.update', $sub_property->id )}}" method="post" autocomplete="off">
                        {{ method_field('patch') }}
                        {{ csrf_field() }}
                        
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" name="name_en" placeholder="sub_property name in English" value={{ $sub_property->getTranslation('name', 'en') }}>
                        </div>
    
    
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" name="name_ar" placeholder="sub_property name in Arabic" value={{ $sub_property->getTranslation('name', 'ar') }}>
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