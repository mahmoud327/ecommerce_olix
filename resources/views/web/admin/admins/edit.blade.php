
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
                        action="{{route('admins.update',$admin->id)}}" enctype="multipart/form-data"   method="post">
                        @method('put')
                        @csrf

                            <div class="col-md-5" id="fnWrapper">
                                <label>name : <span class="tx-danger">*</span></label>
                                <input class="form-control form-control-sm mg-b-20"
                                    data-parsley-class-handler="#lnWrapper" name="name"  type="text" placeholder="Name" value="{{$admin->name}}">
                            </div>
                          
                            <div class="col-md-5" id="fnWrapper">
                                <label>password : <span class="tx-danger">*</span></label>
                                <input class="form-control form-control-sm mg-b-20"
                                    data-parsley-class-handler="#lnWrapper" name="password"  type="password" placeholder="password">
                            </div>
                      
                        

                            <div class="col-md-5" id="fnWrapper">
                                <label>password_confirmation : <span class="tx-danger">*</span></label>
                                <input class="form-control form-control-sm mg-b-20"
                                    data-parsley-class-handler="#lnWrapper" value=""  name="password_confirmation" type="password" placeholder="password_confirmation">
                            </div>
               
                            <div class="col-md-5" id="fnWrapper">
                                <label>email : <span class="tx-danger">*</span></label>
                                <input class="form-control form-control-sm mg-b-20"
                                    data-parsley-class-handler="#lnWrapper" name="email"  type="text" placeholder="email" value="{{$admin->email}}">
                            </div>

                            <div class="col-md-5 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label> {{ trans('lang.phone') }}: <span class="tx-danger">*</span></label>
                                <input class="form-control form-control-sm mg-b-20"
                                    data-parsley-class-handler="#lnWrapper"  name="phone" placeholder="phone"  value="{{$admin->phone}}">
                            </div>
                            
                            <br>

                      
                            
                          
                            <div class="col-md-5 mg-t-20 mg-md-t-0" id="lnWrapper">
                               
                                <label class="form-label"> صلاحية المستخدم</label>
                                <select multiple="multiple" name="roles_name[]" class="js-example-basic-multiple" style="width: 100%">
                                       
                                        @foreach ($roles  as $role)
                                        <option  onlyslave="True"  name="roles_name[]" value="{{$role}}"                                                              
                                            @if(in_array( $role,$adminRole ))  selected   @endif  >
                                            {{$role}}
                                        </option>
                                    @endforeach
                                </select>
                                <br>

                            </div>
                            


                             <br>
                             <div  class="col-md-5 mg-t-20 mg-md-t-0" id="image" >
                                <div class="custom-file">
                                    <input class="custom-file-input" name="image" value="{{$admin->image}}" type="file"> <label class="custom-file-label" for="customFile">Choose image</label>
                                </div>
                            </div>

                            <br>
                              <div class="form-group" id="image_edit">
                                
                                  <img style="width: 80px;height:60px"  src="{{ env('AWS_S3_URL').'/'.$admin->image }}" alt="categories-image">
                               
                            </div>
                            <br>




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

    $("#image").change(function() 
    {
    
        $('#image_edit').css('display','none');
      
    });
    
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
