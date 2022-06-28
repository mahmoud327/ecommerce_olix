
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

</style>
@section('title')
Add admin
@stop


@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">admins</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> /
                admins</span>
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
                        <a class="btn btn-primary btn-sm" href="{{ route('admins.index') }}">{{ trans('lang.back') }}</a>
                    </div>

                    <br>

                    <form class="parsley-style-1" id="selectForm2" autocomplete="off" name="selectForm2"
                        action="{{route('admins.store')}}" enctype="multipart/form-data"   method="post">
                 
                     @csrf

                            <div class="col-md-5" id="fnWrapper">
                                <label>name : <span class="tx-danger">*</span></label>
                                <input class="form-control form-control-sm mg-b-20"
                                    data-parsley-class-handler="#lnWrapper" name="name" value="{{old('name')}}" type="text" placeholder="Name">
                            </div>
                          
                            <div class="col-md-5" id="fnWrapper">
                                <label>password : <span class="tx-danger">*</span></label>
                                <input class="form-control form-control-sm mg-b-20"
                                    data-parsley-class-handler="#lnWrapper" name="password" type="password" placeholder="password">
                            </div>
                      
                        

                            <div class="col-md-5" id="fnWrapper">
                                <label>password_confirmation : <span class="tx-danger">*</span></label>
                                <input class="form-control form-control-sm mg-b-20"
                                    data-parsley-class-handler="#lnWrapper" value=""  name="password_confirmation" type="password" placeholder="password_confirmation">
                            </div>
               
                            <div class="col-md-5" id="fnWrapper">
                                <label>email : <span class="tx-danger">*</span></label>
                                <input class="form-control form-control-sm mg-b-20"
                                    data-parsley-class-handler="#lnWrapper" name="email" value="{{old('email')}}" type="text" placeholder="email">
                            </div>

                            <div class="col-md-5 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label> {{ trans('lang.phone') }}: <span class="tx-danger">*</span></label>
                                <input class="form-control form-control-sm mg-b-20"
                                    data-parsley-class-handler="#lnWrapper" value="{{old('phone')}}" name="phone" placeholder="phone" >
                            </div>
                            
                            <br>
                            <div class="col-md-5 mg-t-20 mg-md-t-0" id="lnWrapper">

                                <label class="form-label"> صلاحية المستخدم</label>
                                <select multiple="multiple" name="roles_name[]" class="js-example-basic-multiple" style="width: 100%">
                                        
                                        @foreach ($roles  as $role)
                                        <option  onlyslave="True"  value="{{$role->name}}">
                                            {{$role->name}}
                                        </option>
                                    @endforeach
                                </select>
                                <br>

                            </div>
                            
                            <br>
                            <br>

                            <div class="form-group">
                                <h4 class="form-section"><i class="ft-home"></i> {{ trans('lang.image') }}</h4>

                                <div id="dpz-multiple-files" class="dropzone dropzone-area">
                                    <div class="dz-message">  {{ trans('lang.uploads') }} </div>
                                </div>

                            </div>


                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button class="btn btn-main-primary pd-x-20" type="submit">{{ trans('lang.save') }}</button>
                        </div>

                    </form>

            </div>

        </div>

@endsection
@push('script')
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
<script>
    var uploadedDocumentMap = {}
   Dropzone.options.dpzMultipleFiles = {
       paramName: "dzfile", // The name that will be used to transfer the file
       //autoProcessQueue: false,
       maxFiles: 1,
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
       url: "{{ route('admin.admins.images.store') }}", // Set the url
       success:
           function (file, response) {
               $('form').append('<input type="hidden" name="document" value="' + response.name + '">')
               uploadedDocumentMap[file.name] = response.name
           }
       ,
       removedfile: function (file)
       {

           file.previewElement.remove()
           var name = ''
           if (typeof file.file_name !== 'undefined') {
               name = file.file_name
           } else {
               name = uploadedDocumentMap[file.name]
           }
           $('form').find('input[name="document"][value="' + name + '"]').remove()
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

    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();

        $('.js-example-basic-multiple').select2({
         closeOnSelect: false

        });
    
    });

</script>


@endpush
