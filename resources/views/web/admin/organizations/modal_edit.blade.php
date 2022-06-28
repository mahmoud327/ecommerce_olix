<div class="modal fade" id="edit{{$organization->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('lang.edit') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                
            </div>
            <div class="modal-body">
    
    
                <form action="{{route('organizations.update',$organization->id)}}" method="post" enctype="multipart/form-data"> 

                    {{ method_field('PUT') }}

                    @csrf
                    <div class="" id="fnWrapper">
                        <label>{{trans('lang.orgniazation_name') }} : <span class="tx-danger">*</span></label>
                       
                    </div>
                           <div class="form-group" id="lnWrapper">
                                <label>     English name: <span class="tx-danger">*</span></label>
                                <textarea class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper"
                                name="name_en" placeholder="English name"   >{{ $organization->getTranslation('name', 'en')}}</textarea>
                            </div>

                            <div class="form-group"id="lnWrapper">
                                <label>Arabic name: <span class="tx-danger">*</span></label>
                                <textarea class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper"
                                name="name_ar" placeholder="Arabic name"   >{{ $organization->getTranslation('name', 'ar')}}</textarea>
                            </div>


                    <div id="other_data_edit" class="tab-pane ">
                        <div class="div_inputs_edit ">
                            <div>
                             
                                @if($organization->phones)    

                                        @foreach ($organization->phones as $phone)
                                            <label>phone</label>
                                                
                                                <input class="form-control form-control-sm mg-b-20"
                                                data-parsley-class-handler="#lnWrapper" name="phones[]" type="text" placeholder="phone"      
                                                value="{{$phone}}">

                                                <br>
                                                <a href="#" class="remove_input_edit btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                                <br>
                                        @endforeach 
                                @endif
                                    
                          </div> 

                        </div>
                         <br>
                          <a href="#" class="add_input_edit btn btn-info btn-sm"><i class="fa fa-plus"></i></a>
                            
                        <br>
            
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">link</label>
                        <input type="text" class="form-control" id="name" name="link" placeholder="arabic name"  value="{{$organization->link}}"> 
                    </div>

                    <div class="form-group">
                        <label>background_cover</label>
                        <input class="form-control form-control-sm mg-b-20"
                        name="background_cover" type="file" value="" >                
                    </div>
                    
            

                    
                    
                    <div class="parsley-input" id="fnWrapper">
                        <label>{{ trans('lang.orgniazation_image') }}: <span class="tx-danger">*</span></label>
                        <br>
                        <input class="form-control form-control-sm mg-b-20"
                        name="image" value="" type="file">
                    </div>
                    
                    <div class="form-group">

                        <label for="exampleFormControlTextarea1">description</label>
                        <textarea type="text" class="form-control" id="name" name="description" placeholder="description">{{$organization->description}}</textarea>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button class="btn btn-main-primary pd-x-20" type="submit">{{ trans('lang.save') }}</button>
                    </div>
                </form>
            </div>
    
         
        </div>
     </div>
    </div>