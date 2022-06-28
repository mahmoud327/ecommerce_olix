@extends('layouts.master')
@section('css')
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<!---Internal Fileupload css-->
<link href="{{URL::asset('assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css"/>
<!---Internal Fancy uploader css-->
<link href="{{URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css')}}" rel="stylesheet" />
<!--Internal Sumoselect css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css')}}">
<!--Internal  TelephoneInput css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css')}}">


@if(App::getLocale() == 'en')
<!--Internal  treeview -->
<link href="{{URL::asset('assets/plugins/treeview/treeview.css')}}" rel="stylesheet" type="text/css" />
@else
<!--Internal  treeview -->
<link href="{{URL::asset('assets/plugins/treeview/treeview-rtl.css')}}" rel="stylesheet" type="text/css" />
@endif


@section('title')
Edit Prodcut
@stop
<style>

    .dropzone .dz-preview .dz-image img
    {
    width: 100%
    }
    .dropzone.dz-clickable {
    border: none;
    }
    .dropzone .dz-preview .dz-details .dz-filename span, .dropzone .dz-preview .dz-details .dz-size span {
     display: none;
    }
    .dropzone .dz-preview:not(.dz-processing) .dz-progress {
      display: none;
     }

   .SumoSelect>.optWrapper.multiple>.options li.opt span i, .SumoSelect .select-all>span i
    {
        position: absolute;
        margin: auto;
        top: 0;
        bottom: 0;
        width: 14px;
        height: 14px;
        border: 1px solid #e1e6f1;
        border-radius: 2px;
        background-color: #fff;
    }

  .SumoSelect>.optWrapper>.options li.opt label, .SumoSelect>.CaptionCont, .SumoSelect .select-all>label {padding-left: 40px;}


 .SumoSelect>.CaptionCont>span {color: #000}
 
</style>


@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">{{ trans('lang.edit')}} </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> / {{ trans('lang.products')}}
                </span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<div class="card">
    <div class="card-body">
                @if (session('status'))

                    <div class="alert alert-success" role="alert">
                        <button type="button" class="btn-close btn-close-white" data-dismiss="alert" aria-label="Close">×</button>
                        {{ session('status') }}
                    </div>

                @elseif(session('failed'))

                    <div class="alert alert-danger" role="alert">
                        <button type="button" class="btn-close btn-close-white" aria-label="Close">×</button>
                        {{ session('failed') }}
                    </div>
                @endif

                @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                @endif

            <div class="pull-right">
            </div>

            <br>
            <form class="parsley-style-1" id="selectForm2" autocomplete="off" name="selectForm2"
               action="{{route('settings.update',$setting->id)}}"  method="post">
               @csrf
               {{ method_field('PUT') }}

               
                    <div id="other_data" class="tab-pane ">
                        <div class="div_inputs ">
                          
                                <div class="col-md-4">
                                    
                                    @foreach (json_decode($setting->phone, true) as $phone)
                                    <label>phone</label>
                                    
                                    <input class="form-control"
                                    data-parsley-class-handler="#lnWrapper" name="phone[]" type="text" placeholder="phone"      
                                    value="{{$phone}}">

                                    <div class="clearfix"></div>
                                    <br>
                                    <a href="#" class="remove_input btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                    <br>
                                    @endforeach
                                    
                                </div>
                                
                         </div>
                            
                        <br>
                
                        <a href="#" class="add_input btn btn-info btn-sm"><i class="fa fa-plus"></i></a>

                    </div>

                    <div id="other_data_email" class="tab-pane ">
                        <div class="div_inputs_email ">
                                <div class="col-md-4">
                                 @foreach (json_decode($setting->email, true) as $email)

                                    <label>email</label>
                                    <input class="form-control"
                                     data-parsley-class-handler="#lnWrapper" name="email[]" type="text" placeholder="email"      
                                    value="{{$email}}">
                                    
                                    <div class="clearfix"></div>
                                    <br>
                                    <a href="#" class="remove_input_email btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                    <br>
                                @endforeach

                                </div>
                        </div>
                        
                        <br>
                        <a href="#" class="add_input_email btn btn-info btn-sm"><i class="fa fa-plus"></i></a>
                     
                       

                    </div>

                    
                    
                  
                    <div class="parsley-input col-md-4" id="fnWrapper">
                        <label>Tw_link</label>

                        <input class="form-control"
                        data-parsley-class-handler="#lnWrapper" name="tw_link" type="text" placeholder="tw_link"      
                        value="{{$setting->tw_link}}">
                    </div>
                    <br>
                  
                    <div class="parsley-input col-md-4" id="fnWrapper">
                        <label>youtube_link</label>

                        <input class="form-control"
                        data-parsley-class-handler="#lnWrapper" name="youtube_link" type="text" placeholder="youtube_link"      
                        value="{{$setting->youtube_link}}">
                    </div>
                    <br>

                    <div class="parsley-input col-md-4 mg-t-20 mg-md-t-0" id="lnWrapper">

                    <label>Fb_link</label>
                        <input class="form-control"
                        data-parsley-class-handler="#lnWrapper" name="Fb_link" type="text" placeholder="Fb_link"      
                        value="{{$setting->Fb_link}}">
                    </div>

                    <br>

                    <div class="parsley-input col-md-4 mg-t-20 mg-md-t-0" id="lnWrapper">
                        <label>Whatsapp</label>
        
                        <input class="form-control"
                        data-parsley-class-handler="#lnWrapper" name="whatsapp" type="text" placeholder="whatsapp"      
                        value="{{$setting->whatsapp}}">
            
                    </div>
                    <br>

                    
                    <div class="parsley-input col-md-4 mg-t-20 mg-md-t-0" id="lnWrapper">
                        <label>Inst_link</label>

                        <input class="form-control"
                        data-parsley-class-handler="#lnWrapper" name="inst_link" type="text" placeholder="inst_link"      
                        value="{{$setting->inst_link}}">
                    </div>
                    <br>

                    <div class="parsley-input col-md-4 mg-t-20 mg-md-t-0" id="lnWrapper">
                        <label>Inst_link</label>

                        <input class="form-control"
                        data-parsley-class-handler="#lnWrapper" name="inst_link" type="text" placeholder="inst_link"      
                        value="{{$setting->inst_link}}">
                    </div>
                    <br>
                    <div class="parsley-input col-md-4 mg-t-20 mg-md-t-0" id="lnWrapper">
                        <label>fax</label>

                        <input class="form-control"
                        data-parsley-class-handler="#lnWrapper" name="fax" type="text" placeholder="fax"      
                        value="{{$setting->fax}}">
                    </div>
                    <br>

              
                    <div class="parsley-input col-md-4 mg-t-20 mg-md-t-0" id="lnWrapper">
                        <label>About us</label>
                        <textarea  rows="8" cols="60" class="form-control" data-parsley-class-handler="#lnWrapper"
                        name="about_us"  placeholder="About Us" >{{$setting->about_us}}</textarea>
                    
                    </div>
                    <br>

                    <div class="parsley-input col-md-4 mg-t-20 mg-md-t-0" id="lnWrapper">
                        <label>Terms and Condition</label>
                        <textarea rows="8" cols="60" class="form-control" data-parsley-class-handler="#lnWrapper"
                        name="terms"  placeholder="Terms" >{{$setting->terms}}</textarea>
                    
                    </div>

              

                    <br>

                    <!--<div id="map" style="height: 500px;width: 1000px;">-->
                    <!--    <input name="lat" type="hidden" value=" ">-->
                    <!--    <input name="lng" type="hidden" value=" ">-->

                    <!--</div>-->
                    <br>
                    <div id="old_image" class="form-group" data-image="{{$setting->medias}}">
                        <h4 class="form-section"><i class="ft-home"></i> {{ trans('lang.image') }}</h4>

                        <div id="dpz-multiple-files" class="dropzone dropzone-area">
                            <div class="dz-message">  {{ trans('lang.uploads') }} </div>
                        </div>
                    
                    </div>
                    <br>


                <div class="text-center">
                    <button class="btn btn-main-primary pd-x-20" type="submit">save</button>
                </div>

            </form>

    </div>

</div>

  

<!-- main-content closed -->
@endsection
@push('script')
<!--Internal  Datepicker js -->
<script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!-- Internal Select2 js-->
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<!--Internal Fileuploads js-->
<script src="{{URL::asset('assets/plugins/fileuploads/js/fileupload.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fileuploads/js/file-upload.js')}}"></script>
<!--Internal Fancy uploader js-->
<script src="{{URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fancyuploder/fancy-uploader.js')}}"></script>
<!--Internal  Form-elements js-->
<script src="{{URL::asset('assets/js/advanced-form-elements.js')}}"></script>
<script src="{{URL::asset('assets/js/select2.js')}}"></script>
<!--Internal Sumoselect js-->
<script src="{{URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js')}}"></script>
<!-- Internal TelephoneInput js-->
<script src="{{URL::asset('assets/plugins/telephoneinput/telephoneinput.js')}}"></script>
<script src="{{URL::asset('assets/plugins/telephoneinput/inttelephoneinput.js')}}"></script>

<script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>


<script type="text/javascript">
    var x=2;
      $(document).on('click','.add_input',function(e){
              e.preventDefault();
              $('.div_inputs').append('<div>'+
            
                  '<div class="col-md-4">'+
                      '<lable>phone</lable>'+
                      '<br>'+

                      '<input type="phone" name="phone[]" class="form-control" placeholder="phone" /> '+
                  '</div>'+
                  '<div class="clearfix"></div>'+
                  '<br>'+
                  '<a href="#" class="remove_input btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>'+
                  '<br>'+
              '</div>');
              x++;
      });
      $(document).on('click','.remove_input',function(){
          $(this).parent('div').remove();
          x--;
          return false;
      });
 </script>

<script type="text/javascript">
    var x=2;
      $(document).on('click','.add_input_email',function(e){
              e.preventDefault();
              $('.div_inputs_email').append('<div>'+
            
                  '<div class="col-md-4">'+
                      '<lable>email</lable>'+
                      '<br>'+

                      '<input type="text" name="email[]" class="form-control" placeholder="email"/> '+
                  '</div>'+
                  '<div class="clearfix"></div>'+
                  '<br>'+
                  '<a href="#" class="remove_input_email btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>'+
                  '<br>'+
              '</div>');
              x++;
      });
      $(document).on('click','.remove_input_email',function(){
          $(this).parent('div').remove();
          x--;
          return false;
      });
 </script>

<script>
    var uploadedDocumentMap = {}
   Dropzone.options.dpzMultipleFiles = {
       paramName: "dzfile", // The name that will be used to transfer the file
       //autoProcessQueue: false,

       clickable: true,
       addRemoveLinks: true,
       acceptedFiles: 'image/*',
       dictFallbackMessage: " المتصفح الخاص بكم لا يدعم خاصيه تعدد الصوره والسحب والافلات ",
       dictInvalidFileType: "لايمكنك رفع هذا النوع من الملفات ",
       dictCancelUpload: "الغاء الرفع ",
       dictCancelUploadConfirmation: " هل انت متاكد من الغاء رفع الملفات ؟ ",
       dictRemoveFile: "{{ trans('lang.delete')}}",

       dictMaxFilesExceeded: "لايمكنك رفع عدد اكثر من هضا ",
       headers: {
           'X-CSRF-TOKEN':
               "{{ csrf_token()}}"
       }
       ,
       url: "{{ route('admin.settings.images.store') }}", // Set the url
       success:
           function (file, response) {
               $('form').append('<input class="images" id="' + response.original_name +'" type="hidden" name="document[]" value="' + response.name + '">')
               
               uploadedDocumentMap[file.name] = response.name
               $('#images').css('display','none');
           }
       ,
     removedfile:function(file)
 	{
        var myarray = new Array();

        $('.images').each(function(index){  

            var input = $(this);
        
            myarray.push(input.val())
            if(input.attr('id') == file.name)
            {
                input.remove();
            }
        });
        var imgSrcValue=  $('img[alt="'+file.name +'"]').prop('alt'); //get the src value

        //  console.log(imgSrcValue);
 		
 		$.ajax({
          
 			url: "{{ URL::to('admin/delete/setting_image') }}",
             type: "GET",
            dataType: "json",
 			data:{  _token:'{{ csrf_token() }}',
                    id:file.id,
                    file_name: file.name, 
                    
                    // name:file,
        
             }
 		});
         var fmock;
 	return (fmock = file.previewElement) != null ? fmock.parentNode.removeChild(file.previewElement):void 0;

 	},
       
       init:function(
  
       ){
  
          @foreach($setting->medias()->get() as $file)
    
            var mock = {name: '{{  $file->url }}',id: '{{ $file->id }}'};
            this.emit('addedfile',mock);
            this.options.thumbnail.call(this,mock,'{{ env('AWS_S3_URL').'/'.$file->path }}');
          @endforeach
             this.on('sending',function(file,xhr,formData){
               formData.append('id','');
              file.id = '';
            });
  
            this.on('success',function(file,response){
              file.id = response.id;
            });
  
          }
  
       // previewsContainer: "#dpz-btn-select-files", // Define the container to display the previews
  
   }
   

</script>

<script>

    let map, infoWindow ;
    var marker;

    function initMap() {


        map = new google.maps.Map(document.getElementById("map"), {
            center: { lat:30.048878086786708, lng: 31.331581115777702 },
            zoom: 8,
        });


        // marker = new google.maps.Marker({

        //     position: { lat:30.048878086786708, lng: 31.331581115777702 },
        //     map: map,
        //     draggable:true

        // });

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                $('input[name="lat"]').val(pos.lat)
                $('input[name="lng"]').val(pos.lng)
                map.setCenter(pos);
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(pos),
                    map: map,
                    draggable:true,
                    title: 'موقعك الحالي'
                });


                map.addListener('click',function(event)
                {

                    if (!marker || !marker.setPosition) {
                            marker = new google.maps.Marker({
                            position:{lat:event.latLng.lat(),lng:event.latLng.lng()},
                            map:map,
                            title:'Test Marker ',
                            draggable:true
                        });
                    } else {
                        marker.setPosition(event.latLng);
                        $('input[name="lat"]').val(event.latLng.lat())
                        $('input[name="lng"]').val(event.latLng.lng())
                        map.setCenter(event.latLng);
                        geocodeLatLng(geocoder, map, infoWindow,marker);


                    }


                });
                    
                google.maps.event.addListener(marker,'dragend',function(markerevent){

                    // console.log(markerevent.latLng.lat());
                    $('input[name="lat"]').val(markerevent.latLng.lat())
                    $('input[name="lng"]').val(markerevent.latLng.lng())
                    map.setCenter(markerevent.latLng);

                });

                // to get current position address on load
                google.maps.event.trigger(marker, 'click');
            }, function() {
                handleLocationError(true, infoWindow, map.getCenter());
            });
        } else {
            
            // Browser doesn't support Geolocation
            handleLocationError(false, infoWindow, map.getCenter());
        }

        infoWindow.open(map);


        setTimeout(function(){
        if($('#map').find('.dismissButton').length == 1){
        $('#map').children('div:nth-of-type(2)').remove();
        }
        },1000);

    }

        $(document).ready(function(){

            initMap();

        });

</script>


<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCgMX047fgChp-jIiyuohSH0h7oY_A614I&libraries=places&callback=initAutocomplete&language=ar&region=EG-->
<!--     async defer"></script>-->

@endpush