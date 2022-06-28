@extends('layouts.master')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
                <a class="btn btn-primary btn-sm" href="{{route('product.productsofcategoryindex',$category_id)}}">{{ trans('lang.back') }}</a>
            </div>

            <br>
        
            <form class="parsley-style-1" id="selectForm2" autocomplete="off" name="selectForm2"
                action="{{route('product.productofcatrgoryupdate',$product->id)}}" enctype="multipart/form-data"   method="post">

                    {{csrf_field()}}

                    <div class="col-lg-5">
                        <label class="rdiobox">
                            <input  name="organization" type="radio" value="personal" {{$product->organization_name =="personal" ? "checked" :""}}  id="personal"> <span> {{ trans('lang.personal') }}
                                </span></label>
                    </div>


                    <div class="col-lg-5">
                        <label class="rdiobox"><input name="organization" id="company" value="company" {{$product->organization_name =="company" ? "checked" : "" }} type="radio"><span> {{ trans('lang.company') }}  
                            </span></label>
                    </div>
                    <div class="row">

                                <div class="col-md-6">
                                    <div class="parsley-input col-md-7" id="div_company" style="display:none" >
                                        <label>{{ trans('lang.orgniazation') }} : <span class="tx-danger">*</span></label>
                                        <br>
                                        @inject('organiztions','App\Models\Organization')
                                        <select name="organization_id" id="cars" class="organization form-control form-control-sm mg-b-20 col-md-7" style="width:55%">

                                            @foreach($organiztions->get() as $organiztion)

                                            <option value="{{$organiztion->id}}" required {{$selected == $organiztion->id ? "selected" : "" }} >{{$organiztion->name}} </option>  
        
                                            @endforeach
                                            
                                        </select>
                                    
                                    </div>

                                    <br>
                                    <br>



                                    <div class="parsley-input col-md-7 mg-t-20 mg-md-t-0" id="lnWrapper">
                                        <label>name: <span class="tx-danger">*</span></label>
                                        <textarea class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper"
                                        name="name_en" placeholder="English name"   >{{ $product->getTranslation('name', 'en')}}</textarea>
                                    </div>

                                    <div class="parsley-input col-md-7 mg-t-20 mg-md-t-0" id="lnWrapper">
                                        <label>name: <span class="tx-danger">*</span></label>
                                        <textarea class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper"
                                        name="name_ar" placeholder="Arabic name"   >{{ $product->getTranslation('name', 'ar')}}</textarea>
                                    </div>

                                    <br>


                                    
                                    <div class="parsley-input col-md-7" id="fnWrapper">
                                        <label>{{ trans('lang.quantity') }} : <span class="tx-danger">*</span></label>
                                        <input class="form-control form-control-sm mg-b-20"
                                            data-parsley-class-handler="#lnWrapper" name="quantity"   value="{{$product->quantity}}" type="number">
                                    </div>

                                    <div class="parsley-input col-md-7 mg-t-20 mg-md-t-0" id="lnWrapper">
                                        <label> {{ trans('lang.price') }}: <span class="tx-danger">*</span></label> <br>
                                        <span class="price"> </span>
                                        <input class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper"
                                            name="price" type="number"   value="{{$product->price}}">
                                    </div>




                                    <div class="col-sm-12">
                                        <p class="mg-b-10">All Filter</p>

                                    <div class="col-md-5 mg-t-20 mg-md-t-0" id="lnWrapper">


                                        @foreach ($filters as $filter)
                                           <div>
                                              <label>{{$filter->name}}<label>
                                            </div>

                                            <select multiple="multiple" class="js-example-basic-multiple" style="width:100%" name="sub_filter[]">
                                                @foreach ($filter->subFiltersRecurring()->get() as $subfilter)
                                                        <option value="{{$subfilter->id}}" 
                                                            @if(in_array( $subfilter->id, json_decode( $product->subFilters->pluck('id') )  ) ) ) selected   @endif >

                                                            {{$subfilter->name}}
                                                        </option>
                                                @endforeach
                                            </select>
                                            <br>
                                        @endforeach

                                        </div>
                                    </div>



                                    <div class="parsley-input col-md-7" id="fnWrapper">
                                        <label>{{ trans('lang.discount') }} : <span class="tx-danger">*</span></label>
                                        <input class="form-control form-control-sm mg-b-20"
                                            data-parsley-class-handler="#lnWrapper" name="discount"  value="{{$product->discount}}" type="text">
                                    </div>

                                    <div id="other_data" class="tab-pane ">
                                        <div class="div_phone_inputs ">
                                            
                                                <div class="col-md-7">
                                                    <label for="phone">phone: </label>
                                                    @if ($product->phone)
                                                        
                                                        @foreach ($product->phone as $phone)
                                                            <label>phone</label>
                                                            
                                                            <input class="form-control"
                                                            data-parsley-class-handler="#lnWrapper" name="phone[]" type="text" placeholder="phone"      
                                                            value="{{$phone}}">
                    
                                                            <div class="clearfix"></div>
                                                            <br>
                                                            <a href="#" class="remove_input btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                                            <br>
                                                        @endforeach
                                                    @endif
                                                    
                                                    
                                                </div>
                                                
                                         </div>
                                            
                                        <br>
                                
                                        <a href="#" class="add_phone_input btn btn-info btn-sm"><i class="fa fa-plus"></i></a>
                
                                    </div>

                                    <div class="parsley-input col-md-7 mg-t-20 mg-md-t-0" id="lnWrapper">
                                        <label> {{ trans('lang.contact') }}: <span class="tx-danger">*</span></label>
                                        <select name="contact"  class="form-control">

                                            <option value="1" {{$product->contact=="1"  ? "selected" : "" }}>{{ trans('lang.phone') }}</option>
                                            <option value="2"  {{$product->contact=="2" ?"selected": ""}}>{{ trans('lang.chat')}}</option>
                                            <option value="3"  {{$product->contact=="3"? "selected": ""}}>{{ trans('lang.all')}}</option>
                                        </select>
                                    </div>
                                    <br>

                                    <div class="parsley-input col-md-7 mg-t-20 mg-md-t-0" id="lnWrapper">
                                        <label>{{ trans('lang.link') }} : <span class="tx-danger">*</span></label>
                                        <input class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper"
                                        name="link" value="{{$product->link}}">
                                    </div>
                                    
                                    <div class="parsley-input col-md-7 mg-t-20 mg-md-t-0" id="lnWrapper">
                                        <label>{{ trans('lang.note_ar') }}: <span class="tx-danger">*</span></label>
                                        <textarea class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper"
                                        name="note_ar"  placeholder="Arabic note" >{{ $product->getTranslation('note', 'ar')}}</textarea>
                                    </div>

                                    <div class="parsley-input col-md-7 mg-t-20 mg-md-t-0" id="lnWrapper">
                                        <label>{{ trans('lang.note_en') }}: <span class="tx-danger">*</span></label>
                                        <textarea class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper"
                                       name="note_en"  placeholder="English note" >{{ $product->getTranslation('note', 'en')}}</textarea>
                                    </div>
                        
                                    <div class="parsley-input col-md-7 mg-t-20 mg-md-t-0" id="lnWrapper">
                                        <label>{{ trans('lang.description') }} : <span class="tx-danger">*</span></label>
                                        <textarea class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper"
                                         name="description" placeholder="Description">{{ $product->description}}</textarea>
                                    </div>

                                    <div class="form-group col-sm-7">
                                        @inject('governorates','App\Models\Governorate')
                                        <select name="governorate_id" id="governorates" class="form-control form-select" style="width:100%" required>
                                            <option> select governorate</option>

                                            @foreach ($governorates->get() as $governorate)

                                                <option  onlyslave="True"  value="{{$governorate->id}}">
                                                    {{$governorate->name}} 
                                                </option>
                                            @endforeach


                                        </select>

                                    </div>
                      
                                      <div class="form-group col-sm-7">

                                            @inject('cities','App\Models\City')

                                            <select name="city_id" id="cities" class="form-control form-select" style="width:100%" required>
                                            
                                                <option value="{{$product->city_id}}" selected>{{optional($product->city)->name}}</option>
                                        
            
                                            </select>

                      
                                      </div>


                                    <br>

                                        <div id="old_image" class="form-group" data-image="{{$product->medias}}">
                                            <h4 class="form-section"><i class="ft-home"></i> {{ trans('lang.image') }}</h4>

                                            <div id="dpz-multiple-files" class="dropzone dropzone-area">
                                                <div class="dz-message">  {{ trans('lang.uploads') }} </div>
                                            </div>
                                        
                                        </div>
                                    
                                </div>

                                <div class="col-md-6">


                                    <div id="other_data" class="tab-pane ">
                                        <div class="div_inputs ">
                                          
                                            <label for="properties">Properties : </label>

                                            @foreach ($product->subProperties as $subProperty)
                                                
                                                <div class="row">
                                                    
                                                    @inject('properties', 'App\Models\Property')
                                                    @inject('sub_properties', 'App\Models\SubProperty')

                                                    <select class="form-control col-md-4 mr-1 properties" required>

                                                        <option value="" disabled selected>Select a property</option>
                                                        @foreach ($properties->all() as $property)

                                                            <label>{{ $property->name }}</label>
                                                            <option value="{{$property->id}}" @if( $subProperty->property->id ==  $property->id ) selected @endif> 
                                                                    {{$property->name}} 
                                                            </option>

                                                        @endforeach

                                                    </select>

                                                    
                                                    <select class="form-control col-md-4 mr-1 sub" name="sub_properties[]" required>

                                                            <option value="" disabled selected>Select a sub property</option>
                                                        
                                                            @foreach ($sub_properties->where('property_id', $subProperty->property_id)->get() as $sub_property)

                                                                <option value="{{$sub_property->id}}" @if( $subProperty->id ==  $sub_property->id ) selected @endif> 
                                                                    {{$sub_property->name}} 
                                                                </option>

                                                            @endforeach
                                                        </select>



                                                    <input class="form-control col-md-3" name="property_price[]" type="number" placeholder="price" value="{{ $subProperty->pivot->price }}" required>
            
                                                    <div class="clearfix"></div>
                                                    <br>
                                                    <a href="#" class="remove_input btn btn-danger btn-sm"><i class="fa fa-times"></i></a>
                                                    <br>

                                                </div>
                                                <br>

                                            @endforeach
                                            

                                            

                                                
                                        </div>
                                            
                                        <br>
                                
                                        <a href="#" class="add_input btn btn-info btn-sm"><i class="fa fa-plus"></i></a>
                
                                    </div>


                                </div>
                                <br>

                                

                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button class="btn btn-main-primary pd-x-20" type="submit">{{ trans('lang.save') }}</button>
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

    var price = $('input[name="price"]').val();
                $(".price").text( parseFloat(price).toLocaleString() );

    $('input[name="price"]').on('keyup', function()
    {
        if($('input[name="price"]').val())
        {
            var price = $('input[name="price"]').val();
            $(".price").text( parseFloat(price).toLocaleString() );

        }
        else
        {
            $(".price").text( " " );
        }
        
    })

</script>
<script>
    

    $(document).ready(function() {

        var val = $('input[type="radio"]:checked').val();
        
        if( val === "personal" ) 
        {
        
            $('#div_company').css('display','none');

        }
        else
        {
            $('#div_company').css('display','inline');

        }

        $('input[type="radio"]#company,input[type="radio"]#personal').on( 'change' ,function() 
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
      var file_name='';
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
       url: "{{ route('admin.products.images.store') }}", // Set the url
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
                file_name = input.val();
                input.remove();
            }                                                                                       
        });

        var imgSrcValue=  $('img[alt="'+file.name +'"]').prop('alt'); //get the src value

        //  console.log(imgSrcValue);
 		
 		$.ajax({
          
 			url: "{{ URL::to('admin/product/delete/image') }}",
             type: "GET",
            dataType: "json",
 			data:{  _token:'{{ csrf_token() }}',
                    id:file.id,
                    file_name: file_name, 
                    
                    // name:file,
        
             }
 		});
         var fmock;
 	return (fmock = file.previewElement) != null ? fmock.parentNode.removeChild(file.previewElement):void 0;

 	},
       
       init:function(
  
       ){
  
          @foreach($product->medias()->orderBy('position')->get() as $file)
    
            var mock = {name: '{{ $file->url }}',id: '{{ $file->id }}'};
            this.emit('addedfile',mock);
            this.options.thumbnail.call(this,mock,'{{ env('AWS_S3_URL').'/'.$file->path }}');          @endforeach
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
          $(document).ready(function() {

            $('#last_level_category:checked').parents('li').css('display','block')
            $('#last_level_category:checked').parents('ul').siblings('i').remveClass('si-folder').addClass('si-folder-alt');

         });

  </script>
  
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