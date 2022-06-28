
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
Add Prodcut
@stop


@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">{{ trans('lang.products') }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> /
                {{ trans('lang.add_product') }}</span>
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
                        <a class="btn btn-primary btn-sm" href="{{route('product.productsofcategoryindex',$category_id)}}">{{ trans('lang.back') }}</a>
                    </div>

                    <br>

                    <form class="parsley-style-1" id="selectForm2" autocomplete="off" name="selectForm2"
                        action="{{route('product.productofcatrgorystore',$category_id)}}" enctype="multipart/form-data"   method="post">

                            {{csrf_field()}}
                            <div class="col-lg-5">
                                <label class="rdiobox">
                                    <input checked name="organization" type="radio"  @if ($organization_name=="personal")  checked  @endif  value="personal"   id="personal"> <span> {{ trans('lang.personal') }}
                                     </span></label>
                            </div>


                            <div class="col-lg-5">
                                <label class="rdiobox"><input name="organization" id="company"  @if ($organization_name=="company")  checked  @endif  value="company" type="radio"><span> {{ trans('lang.company') }}
                                    </span></label>
                            </div>
                            <div class="row">

                                        <div class="col-sm-6">

                                            <div class="parsley-input" id="div_company"  @if($organization_name=="company") style="display:inline" @else  style="display:none"  @endif>

                                                <label>{{ trans('lang.orgniazation') }} : <span class="tx-danger">*</span></label>
                                                <br>
                                                @inject('organiztions','App\Models\Organization')
                                                <select name="organization_id" class="organization form-control form-control-sm mg-b-20"  style="width:55%">

                                                    @foreach($organiztions->get() as $organiztion)

                                                    <option value="{{$organiztion->id}}" {{ $organiztion->name ==$view_selected ?' selected':''  }} required>{{$organiztion->name}} </option>

                                                    @endforeach

                                                </select>

                                            </div>

                                            <br>
                                            <br>

                                            <div class="parsley-input col-md-7 mg-t-20 mg-md-t-0" id="lnWrapper">
                                                <label>name: <span class="tx-danger">*</span></label>
                                                <textarea class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper"
                                                name="name_en" placeholder="English name"   >{{ old('name_en') }}</textarea>
                                            </div>

                                            <div class="parsley-input col-md-7 mg-t-20 mg-md-t-0" id="lnWrapper">
                                                <label>name: <span class="tx-danger">*</span></label>
                                                <textarea class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper"
                                                name="name_ar" placeholder="Arabic name"   >{{ old('name_ar') }}</textarea>
                                            </div>

                                            <br>




                                            <div class="parsley-input col-md-7" id="fnWrapper">
                                                <label>{{ trans('lang.quantity') }} : <span class="tx-danger">*</span></label>
                                                <input class="form-control form-control-sm mg-b-20"
                                                    data-parsley-class-handler="#lnWrapper" name="quantity" value="{{old('quantity')}}" type="number">
                                            </div>

                                            <div class="parsley-input col-md-7 mg-t-20 mg-md-t-0" id="lnWrapper">
                                                <label> {{ trans('lang.price') }}: <span class="tx-danger">*</span></label> <br>
                                                <span class="price"> </span>
                                                <input class="form-control form-control-sm mg-b-20"  value="{{old('price')}}" data-parsley-class-handler="#lnWrapper"
                                                    name="price" type="number" >
                                            </div>

                                            <div class="col-sm-7">

                                                <p class="mg-b-10">All Filter</p>
                                                @foreach ($filters as $filter)
                                                   <div>
                                                      <label>{{$filter->name}}<label>
                                                    </div>

                                                    <select multiple="multiple" name="sub_filter[]" class="js-example-basic-multiple" style="width: 100%">

                                                        @foreach ($filter->subFiltersRecurring()->orderBy('position', 'asc')->get() as $subfilter)
                                                                <option  onlyslave="True"  value="{{$subfilter->id}}">
                                                                    {{$subfilter->name}}
                                                                </option>
                                                        @endforeach
                                                    </select>
                                                    <br>
                                                @endforeach

                                            </div>




                                            <div class="parsley-input col-md-7" id="fnWrapper">
                                                <label>{{ trans('lang.discount') }} : <span class="tx-danger">*</span></label>
                                                <input class="form-control form-control-sm mg-b-20"
                                                    data-parsley-class-handler="#lnWrapper" name="discount" value="{{old('discount')}}" type="text">
                                            </div>



                                            <div id="other_data" class="tab-pane ">
                                                    <div class="div_phone_inputs ">

                                                            <div class="col-md-7">
                                                                    <label>Phone: </label>

                                                                    <input class="form-control"
                                                                    data-parsley-class-handler="#lnWrapper" name="phone[]" type="text" placeholder="phone" >

                                                                    <div class="clearfix"></div>
                                                                    <br>
                                                                    <a href="#" class="remove_input btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                                                    <br>

                                                            </div>

                                                    </div>

                                                    <br>

                                                    <a href="#" class="add_phone_input btn btn-info btn-sm"><i class="fa fa-plus"></i></a>

                                                </div>

                                            <div class="parsley-input col-md-7 mg-t-20 mg-md-t-0" id="lnWrapper">
                                                <label> {{ trans('lang.contact') }}: <span class="tx-danger">*</span></label>
                                                <select name="contact"  class="form-control">

                                                    <option value="1">{{ trans('lang.phone') }}</option>
                                                    <option value="2">{{ trans('lang.chat') }}</option>
                                                    <option value="3" selected>{{ trans('lang.all') }}</option>
                                                </select>
                                            </div>
                                            <br>

                                            <div class="parsley-input col-md-7 mg-t-20 mg-md-t-0" id="lnWrapper">
                                                <label>{{ trans('lang.link') }} : <span class="tx-danger">*</span></label>
                                                <input class="form-control form-control-sm mg-b-20"  value="{{old('link')}}"  data-parsley-class-handler="#lnWrapper"
                                                    name="link" >
                                            </div>

                                            <div class="parsley-input col-md-7 mg-t-20 mg-md-t-0" id="lnWrapper">
                                                <label>{{ trans('lang.note_ar') }}: <span class="tx-danger">*</span></label>
                                                <textarea class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper"
                                                name="note_ar" placeholder="Arabic note">  {{ old('note_ar') }} </textarea>
                                            </div>

                                            <div class="parsley-input col-md-7 mg-t-20 mg-md-t-0" id="lnWrapper">
                                                <label>{{ trans('lang.note_en') }}: <span class="tx-danger">*</span></label>
                                                <textarea class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper"
                                                name="note_en" placeholder="English note"   >{{ old('note_en') }}</textarea>
                                            </div>





                                            <div class="parsley-input col-md-7 mg-t-20 mg-md-t-0" id="lnWrapper">
                                                <label>{{ trans('lang.description') }} : <span class="tx-danger">*</span></label>
                                                <textarea class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper"
                                                    name="description" placeholder="Description">{{old('description_en') }}</textarea>
                                            </div>



                                            <div class="form-group col-md-7">
                                                @inject('governorates','App\Models\Governorate')
                                                <select name="governorate_id" id="governorates" class="form-control form-select" style="width:100%" required>
                                                    <option > select governorate</option>
                                                    @foreach ($governorates->get() as $governorate)

                                                        <option  onlyslave="True"  value="{{$governorate->id}}">
                                                            {{$governorate->name}}
                                                        </option>
                                                    @endforeach


                                                </select>

                                              </div>

                                              <div class="form-group col-md-7">

                                                @inject('cities','App\Models\City')

                                                <select name="city_id" id="cities" class="form-control form-select"  >
                                                    <option disabled> select cities</option>


                                                </select>


                                              </div>


                                                <div class="form-group col-md-7">
                                                    <h4 class="form-section"><i class="ft-home"></i> {{ trans('lang.image') }}</h4>

                                                    <div id="dpz-multiple-files" class="dropzone dropzone-area">
                                                        <div class="dz-message">  {{ trans('lang.uploads') }} </div>
                                                    </div>

                                                </div>
                                                <br>

                                                <input name="lat" type="hidden" value=" ">
                                                <input name="lng" type="hidden" value=" ">


                                                <div id="map" style="height: 500px;width: 1000px;">

                                                </div>

                                                <br>


                                        </div>

                                        <div class="col-md-6">

                                            <label for="properties">Properties : </label>
                                            <div id="other_data" class="tab-pane ">
                                                <div class="div_inputs ">


                                                </div>

                                                <br>

                                                <a href="#" class="add_input btn btn-info btn-sm"><i class="fa fa-plus"></i></a>

                                            </div>
                                            {{-- <div id="all_categories">

                                                <ul id="tree2" >

                                                    @foreach ($parent_categories as $category)
                                                        <li>

                                                            @if ( $category->view->name == 'last_level')
                                                            <input id="last_level_category" type="radio" name="last_categories" value="{{$category->id}}" class="m-2">

                                                            @else

                                                            @endif

                                                            <a href="#" @if ( $category->view->name == 'last_level') style="background-color:#229dff;color:#FFF;padding: 0px 10px;"@endif>{{$category->name}}</a>

                                                            @if ( $category->childs()->count() )
                                                                @include('web.admin.products.tree_category', ['categories'   => $category->childs()])
                                                            @endif

                                                        </li>
                                                    @endforeach

                                                </ul>
                                            </div> --}}

                                        </div>
                                        <br>



                            </div>
                            <div class="col-sm-8 text-center">
                                <button class="btn btn-main-primary pd-x-20" type="submit">{{ trans('lang.save') }}</button>
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

    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();

        $('.js-example-basic-multiple').select2({
         closeOnSelect: false

        });

        $('.organization').select2();

        $('.organization').select2({
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

    <script type="text/javascript">
        var x=2;
        $(document).on('click','.add_input',function(e){
                e.preventDefault();
                $('.div_inputs').append('<div class="row mb-2">'+

                                        '@inject('properties', 'App\Models\Property')'+

                                        '<select class="form-control col-md-4 mr-1 properties" required>'+

                                            '<option value="" disabled selected>Select a property</option>'+
                                            '@foreach ($properties->all() as $property)'+
                                            '<label>{{ $property->name }}</label>'+
                                                '<option value="{{$property->id}}"> '+
                                                    '{{$property->name}} '+

                                                '</option>'+
                                            '@endforeach'+

                                        '</select>'+

                                        '<select class="form-control col-md-4 mr-1" name="sub_properties[]" required>'+

                                            '<option value="" disabled selected>Select a sub property</option>'+


                                        '</select>'+


                                        '<input class="form-control col-md-3" name="property_price[]" type="number" placeholder="price" required>'+

                                        '<div class="clearfix"></div>'+
                                        '<br>'+
                                        '<a href="#" class="remove_input btn btn-danger btn-sm"><i class="fas fa-times"></i></a>'+
                                        '<br>'+

                                    '</div>'+

                                    '<div class="clearfix"></div>');
                x++;
        });
        $(document).on('click','.remove_input',function(){
            $(this).parent('div').remove();
            x--;
            return false;
        });
    </script>


<script>

    $( function(){

        $(document).on('change', '.properties', function(){


            var property_id=  $(this).val();
            var selector = $(this);

            $.ajax({

                url: "{{ URL::to('admin/properties/get_sub_properties') }}/" + property_id,
                type: "GET",
                dataType: "json",
                context: this,
                success: function(response){

                    selector.next('select').empty();

                    selector.next('select').append('<option value="" disabled selected > Select a sub property </option>');
                    $.each(response, function(key, value) {
                        selector.next('select').append('<option value="'+ value.id +'"> '+value.name.en+' </option>');
                    });

                },
            });

        })
    })
</script>

<script>
    var uploadedDocumentMap = {}
   Dropzone.options.dpzMultipleFiles = {
       paramName: "dzfile", // The name that will be used to transfer the file
       //autoProcessQueue: false,

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
       url: "{{ route('admin.products.images.store') }}", // Set the url
       success:
           function (file, response) {
            $('form').append('<input class="images" data-img="' + file.name +'"  type="hidden" name="document[]" value="' + response.name + '">')
               uploadedDocumentMap[file.name] = response.name
           }
       ,
       removedfile: function (file)
       {

        $('.images').each(function(index){

            var input = $(this);

            if(input.data('img') == file.name)
            {
                file_name = input.val()
                input.remove();
            }

        });


        var imgSrcValue=  $('img[alt="'+file.name +'"]').prop('alt'); //get the src value

 		$.ajax({

            url: "{{ URL::to('admin/product/delete/image') }}",
             type: "GET",
            dataType: "json",
 			data:{  _token:'{{ csrf_token() }}',
                    id:file.id,
                    file_name:   file_name,
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
               $('form').append('<input type="hidden" name="document[]" value="' + file.file_name + '">')
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


<script type="text/javascript">
  var x=2;
    $(document).on('click','.add_phone_input',function(e){
            e.preventDefault();
            $('.div_phone_inputs').append('<div>'+

                '<div class="col-md-7">'+
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

<script>

    //if governorates changed
    $("#governorates").change(function (e){
      e.preventDefault();
      // get gov
      var governorate_id = $("#governorates").val();
      //console.log(g);
      if(governorate_id)
      {
        $.ajax({
          url      : '{{url('admin/organization_service_cities?governorate_id=')}}'+governorate_id,
          type     : 'get',
          success  : function (data) {
            if(data.status == 1)
            {

                $("#cities").empty();
                $("#cities").append('<option disabled >select cities</option>');
              $.each(data.data, function(index,city){
                $("#cities").append('<option value="'+city.id+'">'+city.name.en+'</option>');
              });
            }
          },
          error : function (jqXhr, textStatus, errorMessage){
            alert(errorMessage);
          }
        });
      }
      else
      {
        $("#cities").empty();
        $("#cities").append('<option >المدينة</option>');
      }
    });
  </script>
@endpush
