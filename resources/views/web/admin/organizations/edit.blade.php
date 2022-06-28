  
<!--@extends('layouts.master')-->
<!--@section('css')-->
<!-- Internal Nice-select css  -->
<!--<link href="{{URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css')}}" rel="stylesheet" />-->
<!--<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">-->
<!---Internal Fileupload css-->
<!--<link href="{{URL::asset('assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css"/>-->
<!---Internal Fancy uploader css-->
<!--<link href="{{URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css')}}" rel="stylesheet" />-->
<!--Internal Sumoselect css-->
<!--<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css')}}">-->
<!--Internal  TelephoneInput css-->
<!--<link rel="stylesheet" href="{{URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css')}}">-->

<!--@if(App::getLocale() == 'en')-->
<!--Internal  treeview -->
<!--<link href="{{URL::asset('assets/plugins/treeview/treeview.css')}}" rel="stylesheet" type="text/css" />-->
<!--@else-->
<!--Internal  treeview -->
<!--<link href="{{URL::asset('assets/plugins/treeview/treeview-rtl.css')}}" rel="stylesheet" type="text/css" />-->
<!--@endif-->

<!--@section('title')-->
<!--Edit Prodcut-->
<!--@stop-->
<!--<style>-->
<!--    .dropzone .dz-preview .dz-image img-->
<!--    {-->
<!--    width: 100%-->
<!--    }-->
<!--    .dropzone.dz-clickable {-->
<!--    border: none;-->
<!--    }-->
<!--    .dropzone .dz-preview .dz-details .dz-filename span, .dropzone .dz-preview .dz-details .dz-size span {-->
<!--     display: none;-->
<!--    }-->
<!--    .dropzone .dz-preview:not(.dz-processing) .dz-progress {-->
<!--      display: none;-->
<!--     }-->


<!--</style>-->


<!--@endsection-->
<!--@section('page-header')-->
<!-- breadcrumb -->
<!--<div class="breadcrumb-header justify-content-between">-->
<!--    <div class="my-auto">-->
<!--        <div class="d-flex">-->
<!--            <h4 class="content-title mb-0 my-auto">{{ trans('lang.edit')}} </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> / {{ trans('lang.products')}}-->
<!--                </span>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!-- breadcrumb -->
<!--@endsection-->
<!--@section('content')-->
<!--<div class="card">-->
<!--    <div class="card-body">-->
<!--                @if (session('status'))-->

<!--                    <div class="alert alert-success" role="alert">-->
<!--                        <button type="button" class="btn-close btn-close-white" data-dismiss="alert" aria-label="Close">×</button>-->
<!--                        {{ session('status') }}-->
<!--                    </div>-->

<!--                @elseif(session('failed'))-->

<!--                    <div class="alert alert-danger" role="alert">-->
<!--                        <button type="button" class="btn-close btn-close-white" aria-label="Close">×</button>-->
<!--                        {{ session('failed') }}-->
<!--                    </div>-->
<!--                @endif-->

<!--                @if ($errors->any())-->
<!--                        <div class="alert alert-danger">-->
<!--                            <ul>-->
<!--                                @foreach ($errors->all() as $error)-->
<!--                                    <li>{{ $error }}</li>-->
<!--                                @endforeach-->
<!--                            </ul>-->
<!--                        </div>-->
<!--                @endif-->

<!--            <div class="pull-right">-->
<!--                <a class="btn btn-primary btn-sm" href="{{route('organization.index',$organization->organization_type_id)}}">{{ trans('lang.back') }}</a>-->
<!--            </div>-->

<!--            <br>-->
        
<!--          <form action="{{route('organization.update',$organization->id)}}" method="post" enctype="multipart/form-data"> -->

<!--                    {{ method_field('PUT') }}-->

<!--                    @csrf-->
<!--                    <div class="" id="fnWrapper">-->
<!--                        <label>{{trans('lang.orgniazation_name') }} : <span class="tx-danger">*</span></label>-->
<!--                        <input class="form-control form-control-sm mg-b-20"-->
<!--                            data-parsley-class-handler="#lnWrapper" name="name" type="text"   value="{{$organization->name}}" required>-->
<!--                    </div>-->


<!--                    <div id="other_data_edit" class="tab-pane ">-->
<!--                        <div class="div_inputs_edit ">-->
<!--                            <div>-->
                             
<!--                                @if($organization->phones)    -->

<!--                                        @foreach (json_decode($organization->phones, true) as $phone)-->
<!--                                            <label>phone</label>-->
                                                
<!--                                                <input class="form-control form-control-sm mg-b-20"-->
<!--                                                data-parsley-class-handler="#lnWrapper" name="phones[]" type="text" placeholder="phone"      -->
<!--                                                value="{{$phone}}">-->

<!--                                                <br>-->
<!--                                                <a href="#" class="remove_input_edit btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>-->
<!--                                                <br>-->
<!--                                        @endforeach -->
<!--                                @endif-->
                                    
<!--                          </div> -->

<!--                        </div>-->
<!--                         <br>-->
<!--                          <a href="#" class="add_input_edit btn btn-info btn-sm"><i class="fa fa-plus"></i></a>-->
                            
<!--                        <br>-->
            
<!--                    </div>-->

<!--                    <div class="form-group">-->
<!--                        <label for="exampleFormControlTextarea1">link</label>-->
<!--                        <input type="text" class="form-control" id="name" name="link" placeholder="arabic name"  value="{{$organization->link}}"> -->
<!--                    </div>-->

<!--                    <div class="form-group">-->
<!--                        <label>background_cover</label>-->
<!--                        <input class="form-control form-control-sm mg-b-20"-->
<!--                        name="background_cover" type="file" value="{{$organization->background_cover}}"  >                -->
<!--                    </div>-->
                    
            

                    
                    
<!--                    <div class="form-group" id="image" >-->
<!--                                    <div class="custom-file">-->
<!--                                        <input class="custom-file-input" name="image" value="{{$organization->image}}" type="file"> <label class="custom-file-label" for="customFile">Choose image</label>-->
<!--                                    </div>-->
<!--                             </div>-->
                    
<!--                    <div class="form-group">-->

<!--                        <label for="exampleFormControlTextarea1">description</label>-->
<!--                        <textarea type="text" class="form-control" id="name" name="description" placeholder="description">{{$organization->description}}</textarea>-->
<!--                    </div>-->

<!--                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">-->
<!--                        <button class="btn btn-main-primary pd-x-20" type="submit">{{ trans('lang.save') }}</button>-->
<!--                    </div>-->
<!--                </form>-->
                        
<!--                </div>-->

<!--            </form>-->

<!--    </div>-->

<!--</div>-->

  

<!-- main-content closed -->
<!--@endsection-->
<!--@push('script')-->
<!--Internal  Datepicker js -->
<!--<script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>-->
<!--Internal  jquery.maskedinput js -->
<!--<script src="{{URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js')}}"></script>-->
<!--Internal  spectrum-colorpicker js -->
<!--<script src="{{URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js')}}"></script>-->
<!-- Internal Select2.min js -->
<!--<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>-->
<!--Internal Ion.rangeSlider.min js -->
<!--<script src="{{URL::asset('assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js')}}"></script>-->
<!--Internal  jquery-simple-datetimepicker js -->
<!--<script src="{{URL::asset('assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js')}}"></script>-->
<!-- Ionicons js -->
<!--<script src="{{URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js')}}"></script>-->
<!--Internal  pickerjs js -->
<!--<script src="{{URL::asset('assets/plugins/pickerjs/picker.min.js')}}"></script>-->
<!-- Internal form-elements js -->
<!--<script src="{{URL::asset('assets/js/form-elements.js')}}"></script>-->

<!--<script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>-->

<!--<script type="text/javascript">-->

<!--        var x=2;-->
<!--          $(document).on('click','.add_input_edit',function(e){-->
<!--                  e.preventDefault();-->
<!--                  $('.div_inputs_edit').append('<div>'+-->
                
<!--                          '<lable>phone</lable>'+-->
<!--                          '<br>'+-->
    
<!--                          '<input type="phone" name="phones[]" class="form-control" placeholder="phone" /> '+-->
<!--                      '<div class="clearfix"></div>'+-->
<!--                      '<br>'+-->
<!--                      '<a href="#" class="remove_input_edit btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>'+-->
<!--                      '<br>'+-->
<!--                  '</div>');-->
<!--                  x++;-->
<!--          });-->
<!--          $(document).on('click','.remove_input_edit',function(){-->
<!--              $(this).parent('div').remove();-->
<!--              x--;-->
<!--              return false;-->
<!--          });-->
<!--  </script>-->





<!--@endpush-->