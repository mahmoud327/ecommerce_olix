@extends('layouts.master')
@section('css')
<!-- Internal Select2 css -->
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<!--Internal  Datetimepicker-slider css -->
<link href="{{URL::asset('assets/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/pickerjs/picker.min.css')}}" rel="stylesheet">
<!-- Internal Spectrum-colorpicker css -->
<link href="{{URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css')}}" rel="stylesheet">


<link href="{{URL::asset('assets/plugins/fontawesome-free/css/all.min.css')}}" rel="stylesheet">

@if(App::getLocale() == 'en')
<!--Internal  treeview -->
<link href="{{URL::asset('assets/plugins/treeview/treeview.css')}}" rel="stylesheet" type="text/css" />
@else
<!--Internal  treeview -->
<link href="{{URL::asset('assets/plugins/treeview/treeview-rtl.css')}}" rel="stylesheet" type="text/css" />
@endif

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
                        <h4 class="content-title mb-0 my-auto">Dashboard</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Create Recurring Filter</span>
                    </div>
                </div>
            </div>
            <!-- breadcrumb -->
@endsection
@section('content')




        @if ($errors->any())

            <div class="col-lg-12 col-md-12">

                <div class="card bd-0 mg-b-20 bg-danger-transparent alert p-0">
                    <div class="card-header text-danger font-weight-bold">
                        <i class="far fa-times-circle"></i> Error Data
                        <button aria-label="Close" class="close" data-dismiss="alert" type="button"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="card-body text-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <!--Page Widget Error-->

            </div>
        @endif



        @if (session()->has('edit'))

            <div class="col-lg-12 col-md-12">
                <!--Page Widget Error-->
                <div class="card bd-0 mg-b-20 bg-info-transparent alert p-0">
                    <div class="card-header text-info font-weight-bold">
                        <i class="far fa-question-circle"></i> Info Data
                        <button aria-label="Close" class="close" data-dismiss="alert" type="button"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="card-body text-info">
                        <strong>Heads up!</strong> {{ session()->get('edit') }}
                    </div>
                </div>
                <!--Page Widget Error-->
            </div>
        @endif

        @if (session()->has('delete'))

            <div class="col-lg-12 col-md-12">

                <div class="card bd-0 mg-b-20 bg-danger-transparent alert p-0">
                    <div class="card-header text-danger font-weight-bold">
                        <i class="far fa-times-circle"></i> Error Data
                        <button aria-label="Close" class="close" data-dismiss="alert" type="button"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="card-body text-danger">
                        <strong>Oh snap!</strong> {{ session()->get('delete') }}
                    </div>
                </div>
                <!--Page Widget Error-->

            </div>
        @endif


        <!-- row -->
        <div class="row row-sm">
            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                <div class="card  box-shadow-0">
                    <div class="card-header">
                        {{-- <h4 class="card-title mb-1">Default Form</h4>
                        <p class="mb-2">It is Very Easy to Customize and it uses in your website apllication.</p>--}}
                    </div> 
                    <div class="card-body pt-0">
                            <form action="{{route('recurring_sub_filters.update', $recurring_sub_filter->id )}}" method="post" autocomplete="off" enctype="multipart/form-data">
                                {{ method_field('patch') }}
                                {{ csrf_field() }}
                                
                                <div class="col-sm-4">
                                    <input class="form-control" name="name_en" id="name_en" type="text" value="{{ $recurring_sub_filter->getTranslation('name', 'en') }}" placeholder="Recurring Sub Filters Name in Engilsh">
                                </div>
                                <br>
                                <div class="col-sm-4 ">
                                    <input class="form-control" name="name_ar" id="name_ar" type="text" value="{{ $recurring_sub_filter->getTranslation('name', 'ar') }}" placeholder="Recurring Sub Filters Name in Arabic">
                                </div>
                             
                                <br>
                                <br>
                            
                                <div id="old_image" class="form-group" data-image="{{$recurring_sub_filter->image}}">
                                    <h4 class="form-section"><i class="ft-home"></i> {{ trans('lang.image') }}</h4>

                                    <div id="dpz-multiple-files" class="dropzone dropzone-area">
                                        <div class="dz-message">  {{ trans('lang.uploads') }} </div>
                                    </div>
                                
                                </div>

                                <br>
                                <div class="" style="margin-left:30%">
                                    <button type="submit" class="btn btn-primary">Save</button>

                                </div>
                            
                                
                             
                            </form>
                            
                    </div>
                </div>
            </div>

        </div>
        <!-- row -->

@endsection
@section('js')
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


@endsection

@push('script')
<script>
    var uploadedDocumentMap = {}
   Dropzone.options.dpzMultipleFiles = {
       paramName: "dzfile", // The name that will be used to transfer the file
       //autoProcessQueue: false,
       maxFiles:1,

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
       url: "{{ route('admin.recurring_sub_filters.images.store') }}", // Set the url
       success:
           function (file, response) {
               $('form').append('<input class="images" id="' + response.original_name +'" type="hidden" name="document" value="' + response.name + '">')
               
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
 		
 		
         var fmock;
 	return (fmock = file.previewElement) != null ? fmock.parentNode.removeChild(file.previewElement):void 0;

 	},
       
       init:function(
  
       ){
  
        
            var mock = {name: '{{URL::to('/').'/uploads/RecuringSubFilter/'.$recurring_sub_filter->image }}'};
            this.emit('addedfile',mock);
            this.options.thumbnail.call(this,mock,'{{ url(env('AWS_S3_URL').'/uploads/RecuringSubFilter/'.$recurring_sub_filter->image) }}');
       
        
  
            this.on('success',function(file,response){
              file.id = response.id;
            });
  
          }
  
       // previewsContainer: "#dpz-btn-select-files", // Define the container to display the previews
  
   }
   

</script>

  @endpush