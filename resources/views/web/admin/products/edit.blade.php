  
@extends('layouts.master')
@section('css')
<!-- Internal Nice-select css  -->
<link href="{{URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css')}}" rel="stylesheet" />
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
                <a class="btn btn-primary btn-sm" href="{{ route('products.index') }}">{{ trans('lang.back') }}</a>
            </div>

            <br>
        
            <form class="parsley-style-1" id="selectForm2" autocomplete="off" name="selectForm2"
                action="{{route('products.update',$product->id)}}" enctype="multipart/form-data"   method="post">

                    {{csrf_field()}}
                    {{ method_field('PUT') }}

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
                                <div class="col-sm-7">
                                    <div class="parsley-input col-md-7" id="div_company" style="display:none" >
                                        <label>{{ trans('lang.orgniazation') }} : <span class="tx-danger">*</span></label>
                                        @inject('organiztions','App\Models\Organization')
                                        <select name="organization_id" id="cars" class="form-control form-control-sm mg-b-20 col-md-7">

                                            @foreach($organiztions->get() as $organiztion)

                                            <option value="{{$organiztion->id}}" required {{$selected == $organiztion->id ? "selected" : "" }} >{{$organiztion->name}} </option>  
        
                                            @endforeach
                                            
                                        </select>
                                    
                                    </div>

                                    <br>



                                    <div class="parsley-input col-md-7" id="fnWrapper">
                                        <label>{{ trans('lang.product_name') }} : <span class="tx-danger">*</span></label>
                                        <input class="form-control form-control-sm mg-b-20"
                                          data-parsley-class-handler="#lnWrapper" name="name" type="text" placeholder="Name"      
                                        value="{{ $product->name}}">
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


                                    <div class="parsley-input col-md-7" id="fnWrapper">
                                        <label>{{ trans('lang.discount') }} : <span class="tx-danger">*</span></label>
                                        <input class="form-control form-control-sm mg-b-20"
                                            data-parsley-class-handler="#lnWrapper" name="discount"  value="{{$product->discount}}" type="text">
                                    </div>

                                    <div class="parsley-input col-md-7 mg-t-20 mg-md-t-0" id="lnWrapper">
                                        <label> {{ trans('lang.phone') }}: <span class="tx-danger">*</span></label>
                                        <input class="form-control form-control-sm mg-b-20"
                                        data-parsley-class-handler="#lnWrapper" name="phone" value="{{$product->phone}}"  >
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


                                    <br>


                                        <div id="old_image" class="form-group" data-image="{{$product->medias}}">
                                            <h4 class="form-section"><i class="ft-home"></i> {{ trans('lang.image') }}</h4>

                                            <div id="dpz-multiple-files" class="dropzone dropzone-area">
                                                <div class="dz-message">  {{ trans('lang.uploads') }} </div>
                                            </div>
                                        
                                        </div>

                                    
                                </div>
                            
                                <div class="col-sm-5">

                                    <div id="all_categories">

                                        <ul id="tree2" >

                                            @foreach ($parent_categories as $category)
                                                <li> 

                                                    @if ($category->view->name == 'last_level' )

                                                        <input id="last_level_category" type="radio" name="last_categories" value="{{$category->id}}" class="m-2" @isset($category_id)
                                                        @if( $category->id ==  $category_id) checked @endif
                                                    @endisset>


                                                    @else

                                                    @endif

                                                    <a href="#" @if ( $category->view->name == 'last_level' || $category->view->name == 'اخر قسم' ) style="background-color:#229dff;color:#FFF;padding: 0px 10px;"@endif>{{$category->name}}</a>

                                                    @if ( $category->childs()->count() )
                                                        @include('web.admin.products.tree_category', ['categories'   => $category->childs()])
                                                    @endif
                                                    
                                                </li>
                                            @endforeach

                                        </ul>
                                    </div>

                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                    <button class="btn btn-main-primary pd-x-20" type="submit">{{ trans('lang.save') }}</button>
                                </div>

                    </div>
            </form>

    </div>

</div>

  

<!-- main-content closed -->
@endsection
@push('script')
<!--Internal  Datepicker js -->
<script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!--Internal  jquery.maskedinput js -->
<script src="{{URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js')}}"></script>
<!--Internal  spectrum-colorpicker js -->
<script src="{{URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js')}}"></script>
<!-- Internal Select2.min js -->
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<!--Internal Ion.rangeSlider.min js -->
<script src="{{URL::asset('assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js')}}"></script>
<!--Internal  jquery-simple-datetimepicker js -->
<script src="{{URL::asset('assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js')}}"></script>
<!-- Ionicons js -->
<script src="{{URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js')}}"></script>
<!--Internal  pickerjs js -->
<script src="{{URL::asset('assets/plugins/pickerjs/picker.min.js')}}"></script>
<!-- Internal form-elements js -->
<script src="{{URL::asset('assets/js/form-elements.js')}}"></script>

<script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>

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
               "{{ csrf_token() }}"
       }
       ,
       url: "{{ route('admin.products.images.store') }}", // Set the url
       success:
           function (file, response) {
               $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">')
               
               uploadedDocumentMap[file.name] = response.name
               $('#images').css('display','none');
           }
       ,
     removedfile:function(file)
 	{
         
        var imgSrcValue=  $('img[alt="'+file.name +'"]').prop('alt'); //get the src value

         console.log(imgSrcValue);
 		
 		$.ajax({
          
 			url: "{{ URL::to('admin/delete/image') }}",
             type: "GET",
            dataType: "json",
 			data:{  _token:'{{ csrf_token() }}',
                    id:file.id,
                    // name:file,
             
             }
 		});
         var fmock;
 	return (fmock = file.previewElement) != null ? fmock.parentNode.removeChild(file.previewElement):void 0;

 	},
       
       init:function(
  
       ){
  
          @foreach($product->medias()->get() as $file)
    
            var mock = {name: '{{ $file->url }}',id: '{{ $file->id }}'};
            this.emit('addedfile',mock);
            this.options.thumbnail.call(this,mock,'{{ url($file->path) }}');
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
          $(document).ready(function() {

            $('#last_level_category:checked').parents('li').css('display','block')
            $('#last_level_category:checked').parents('ul').siblings('i').remveClass('si-folder').addClass('si-folder-alt');

         });


  </script>
  

@endpush