
@extends('layouts.master')
@section('css')
<!---Internal Fileupload css-->
<link href="{{URL::asset('assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css"/>
<!---Internal Fancy uploader css-->
<link href="{{URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css')}}" rel="stylesheet" />
<!--Internal Sumoselect css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css')}}">
<!--Internal  TelephoneInput css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css')}}">


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@if(App::getLocale() == 'en')
<!--Internal  treeview -->
<link href="{{URL::asset('assets/plugins/treeview/treeview.css')}}" rel="stylesheet" type="text/css" />
@else
<!--Internal  treeview -->
<link href="{{URL::asset('assets/plugins/treeview/treeview-rtl.css')}}" rel="stylesheet" type="text/css" />
@endif

<style>
.SumoSelect>.CaptionCont {
    width: 60%;

    }
.dropzone.dz-clickable
{
border: none;
}
.dropzone .dz-preview:not(.dz-processing) .dz-progress
{
display: none;
}

.dropzone .dz-preview .dz-details .dz-filename:not(:hover) span
{
display: none;
}
.dropzone .dz-preview .dz-details .dz-filename span, .dropzone .dz-preview .dz-details .dz-size span
{
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

.SumoSelect.open>.optWrapper {
    width: 550px;
}



</style>
@section('title')
Add advertisment
@stop


@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">advertisment</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> /
                add  advertisment</span>
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
                        <a class="btn btn-primary btn-sm" href="{{route('advertisments.index',$category_id)}}">{{ trans('lang.back') }}</a>
                    </div>

                    <br>

                    <form action="{{route('advertisments.store')}}" method="post" enctype="multipart/form-data">
                    
                        @csrf

                        @if($categories->count())

                            <input type="hidden" name="category_id" value="{{$category_id}}"/>
                            @else
                            <input type="hidden" name="category_id" value="0"/>
                            @endif
                            <div class="" id="div_link">
                                <input type="url" class="form-control" name="link" id="link" value=""  style="width:32%" placeholder="link">
                            </div> 
                            <br>
                            
                            <div class="" id="div_type" >
                                <select class="form-control" id="type"  name="type" aria-label="Default select example" style="width:32%">
                                    <option value=''>  select type  </option>
                                    <option value="product">  product  </option>
                                    <option value="organization">organization </option>
                                  </select>
                             </div>
                             <br>

                             @inject('products','App\Models\Product')
                             <div class="" style="display:none" id="products">

                                <select  name="product_id" class="products" style="width:32%">

                                    <option value="">  select product  </option>
                                    @foreach ($products->get() as $product)

                                            <option  onlyslave="True"  value="{{$product->id}}">
                                                {{$product->name}}
                                            </option>
                                    @endforeach
                                </select>
                             </div>

                            @inject('organizations','App\Models\Organization')
                             <div class="col-sm-2" style="display:none" id="organizations">

                                <select  name="organization_id" class="organizations" style="width:32%">
                                    <option value="" >  select organization  </option>
                                    @foreach ($organizations->get() as $organization)
                                            <option  onlyslave="True"  value="{{$organization->id}}">
                                                {{$organization->name}}
                                            </option>
                                    @endforeach
                                </select>
                            </div>

                            
                            <br>
                            <br>
                            <div class="form-group">
                                <h4 class="form-section"><i class="ft-home"></i> {{ trans('lang.image') }}</h4>
    
                                <div id="dpz-multiple-files" class="dropzone dropzone-area">
                                    <div class="dz-message">  {{ trans('lang.uploads') }} 
                                </div>
                                </div>
    
                            </div>
    
    
                            <div class="">
                                <button type="submit" class="btn btn-primary">تاكيد</button>
                            </div>
    
    
                    
                    </form>

            </div>

        </div>

@endsection
@push('script')
<script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!-- Internal Select2 js-->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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

<script>

   $('#link').on('keyup', function()
   {
     var link = $('#link').val();
     if(link=='')
     {

     $('#div_type').css('display','inline');
     }

     else
     {
        $('#div_type').css('display','none');
     }

   });

   $('#type').on('change', function()
   {
     var type = $('#type').val();

     if(type =='product'|| type == 'organization' )
     {

       $('#div_link').css('display','none');
     }
     else
     {
       $('#div_link').css('display','inline');

     }

   

   });


    $(document).ready(function() {
        $('.products').select2();

        $('.products').select2({
         closeOnSelect: false

        });

        $('.organizations').select2();

        $('.organizations').select2({
         closeOnSelect: false

        });
    
    });

</script>


<script>


    $('input[name="price"]').on('keyup', function(){

        if($('input[name="price"]').val())
        {
            var price = $('input[name="price"]').val();
            $(".price").text( parseFloat(price).toLocaleString() );

        }else
        {
            $(".price").text( " " );
        }
        
    })

</script>

<script>

$(document).ready(function() {

    $('input[type="radio"]#company , input[type="radio"]#personal').on( 'change' ,function()
    {
        var value = $(this).val();

    if(value === "company")
    {

        $('#div_company').css('display','inline');
    }
    else
    {
        $('#div_company').css('display','none');

    }

    });

 });


 </script>

  <script>
    //if  type changed
    $("#type").change(function (e){
      e.preventDefault();
      // get gov
      var type = $("#type").val();
      //console.log(g);
      if(type == "organization")
      {
          $('#products').css('display','none');
          $('#organizations').css('display','inline');

          
      }
      else if(type=="product")
      {
        $('#organizations').css('display','none');
        $('#products').css('display','inline');

      }
      else
      {
        $('#organizations').css('display','none');
        $('#products').css('display','none');


      }
    });
  </script>
<script>
    var uploadedDocumentMap = {}
   Dropzone.options.dpzMultipleFiles = {
       paramName: "dzfile", // The name that will be used to transfer the file
       //autoProcessQueue: false,
        maxFiles: 1,

          // MB
       clickable: true,
       addRemoveLinks: true,
       acceptedFiles: 'image/*',
       dictFallbackMessage: " المتصفح الخاص بكم لا يدعم خاصيه تعدد الصوره والسحب والافلات ",
       dictInvalidFileType: "لايمكنك رفع هذا النوع من الملفات ",
       dictCancelUpload: "الغاء الرفع ",
       dictCancelUploadConfirmation: " هل انت متاكد من الغاء رفع الملفات ؟ ",
       dictRemoveFile: "حذف الصوره",

       dictMaxFilesExceeded: "لايمكنك رفع عدد اكثر من هضا ",
       headers: {
           'X-CSRF-TOKEN':
               "{{ csrf_token()}}"
       }
       ,
       url: "{{ route('admin.advertisment.images.store') }}", // Set the url
       success:
           function (file, response) {
            $('form').append('<input class="images" id="' + response.name +'" type="hidden" name="document" value="' + response.name + '">')
               uploadedDocumentMap[file.name] = response.name
           }
       ,
       removedfile: function (file)
       {

        var old_image= $('.images').attr('id');
       
        
        var imgSrcValue=  $('img[alt="'+file.name +'"]').prop('alt'); //get the src value
        
        //  console.log(imgSrcValue);

 		$.ajax({
          
 			url: "{{ URL::to('admin/delete/image') }}",
             type: "GET",
            dataType: "json",
 			data:{  _token:'{{ csrf_token() }}',
                    id:file.id,
                    file_name: file.name, 
                    old_image:old_image
             }
 		});
         var fmock;
 	      return (fmock = file.previewElement) != null ? fmock.parentNode.removeChild(file.previewElement):void 0;
       }
       ,
       // previewsContainer: "#dpz-btn-select-files", // Define the container to display the previews
       init: function () {
               @if(isset($event) && $event->document)
           var files =
           {!! json_encode($event->document) !!}
               for (var i in files)
               {
               var file = files[i]
               this.options.addedfile.call(this, file)
               file.previewElement.classList.add('dz-complete')
               $('form').append('<input type="hidden" name="document" value="' + file.file_name + '">')
           }
           @endif
       }

       
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


<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCgMX047fgChp-jIiyuohSH0h7oY_A614I&libraries=places&callback=initAutocomplete&language=ar&region=EG
     async defer"></script>



@endpush
