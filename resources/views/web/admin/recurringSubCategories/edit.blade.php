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
                        <h4 class="content-title mb-0 my-auto">لوحة التحكم</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل فئة فرعية</span>
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

                <div class="card  box-shadow-0">

                    <div class="card-header">
                        {{-- <h4 class="card-title mb-1">Default Form</h4>
                        <p class="mb-2">It is Very Easy to Customize and it uses in your website apllication.</p>--}}
                    </div> 
                    <br>
               
                    <div class="card-body pt-0">
                        <form class="form-horizontal" method="post" action="{{route('recurring_categories.update',$recurring_category)}}" enctype="multipart/form-data">
                            @method('patch')
                            @csrf

                            <div class="row">

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label> Name Of Filter: </label>
                                        <input type="text" name="name_en" class="form-control" id="inputName" placeholder="Name in English" value="{{$recurring_category->getTranslation('name' , 'en')}}">
                                        <br>
                                
                                        <input type="text" name="name_ar" class="form-control" id="inputName" placeholder="Name in Arabic" value="{{$recurring_category->getTranslation('name' , 'ar')}}">	
                                    </div>

                                    <div class="form-group">
                                        <textarea class="form-control" name="description_ar" placeholder="Arabic description"  rows="3">{{$recurring_category->getTranslation('description' , 'ar')}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control" name="description_en" placeholder="English description"  rows="3">{{$recurring_category->getTranslation('description' , 'en')}}</textarea>
                                    </div>
                                    
                                    <div class="form-group">
                                        <select class="form-control select2" name="view_id" id="view"> 
                                        
                    
                                            @foreach($views as $view) 
                                                <option value="{{$view->id}}" @if($recurring_category->view_id == $view->id) selected @endif >{{$view->name}}</option>
                                            @endforeach 
                                        </select>
                                    </div>

                                <div id="image" class="form-group"  >
                                          <div class="custom-file">
                                              <input class="custom-file-input" name="image" value="" type="file"> <label class="custom-file-label" for="customFile">Choose image</label>
                                          </div>
                                      </div>
    
                                 </div>
                                
                                
                                <div class="col-lg-4">
                                    <label>Category :</label>
                                    <div id="all_categories">

                                        <ul id="tree2" >
                                              
                                            @foreach ($parentCategories as $category)
                                                <li>  
                                                   
                                                    <input id="last_level_category" type="checkbox" name="categories_list[]" value="{{$category->id}}" class="m-2" @if( in_array( $category->id, json_decode( $categories_id )) ) checked @endif>

                                                      <a href="#" @if ( $category->view->name == 'last_level' ) style="background-color:#229dff;color:#FFF;padding: 0px 10px;"@endif>{{$category->name}}</a>

                                                    @if ( $category->childs()->count() )
                                                        @include('web.admin.recurringSubCategories.tree_category', ['categories'   => $category->childs(), 'categories_id'  => $categories_id])
                                                    @endif
                                                    
                                                </li>
                                            @endforeach

                                        </ul>
                                    </div>
                                </div>

                             
                                <div class="col-lg-4">
                                    <label> Accounts: </label><br>


                                    <input type="checkbox" id="check_all_accounts" class="m-2"><span>All Accounts</span>

                                    <ul id="treeview1">

                                        @foreach ($accounts as $account)
                                        
                                            <li id="account"><input id="account" @if ( $account->name == 'suiiz') checked  onclick="return false;" class="suiiz"  @endif type="checkbox"  style="margin:3px"><a href="#">{{$account->name}}</a>
                                                
                                                <ul>
                                                    @foreach ($account->subAccounts()->get() as $sub_account)
                                            
                                                        <li id="sub_account" >
                                                            
                                                            <input id="sub_account" @if ( $sub_account->name == 'suiiz' ) checked onclick="return false;" class="suiiz" @endif @if(in_array( $sub_account->id, json_decode( $sub_accounts_id_of_recurring_category))) checked   @endif   type="checkbox" style="margin:3px"  name="sub_account[]" value="{{$sub_account->id}}" class="m-2">{{$sub_account->name}}
                                                            
                                                        </li>

                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endforeach
                                    </ul>       
                                </div>
 
                            </div>

                            <div class="col-lg-10 mt-5 text-center">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
 
                        </form>
                    </div>
                </div>
  

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


{{-- to chceck all sub categories --}}
<script>

    $(function (){
        $('input#check_all_subs').on( 'change' ,function() 
        {
            if($(this).is(':checked'))
            {
                $(this).parent('li').siblings('li').find('input[type="checkbox"]').prop('checked',true);
            }else
            {
                $(this).parent('li').siblings('li').find('input[type="checkbox"]').prop('checked',false);

            }
        })
    })

</script>

<script>



    $(function (){
        
        $('input#account').on('change', function(){

            if($(this).is(':checked'))
            {
                $(this).siblings('i').removeClass('si-plus').addClass('si-minus');
                $(this).siblings('ul').find('li').css("display", "block");
                $(this).siblings('ul').find('input#sub_account').prop('checked',true);


            }else
            {
                // $(this).siblings('i').addClass('si-plus').removeClass('si-minus');
                // $(this).siblings('ul').find('li').css("display", "none");
                $(this).siblings('ul').find('input#sub_account').prop('checked',false);


            }
            
        })

        $('input#sub_account').on('change', function(){


            var all_childs = $(this).parent('li').parent('ul').find('input#sub_account').length;
            var checked_childs = $(this).parent('li').parent('ul').find('input#sub_account:checked').length;

            if( all_childs === checked_childs)
            {
                $(this).parent('li').parent('ul').siblings('input#account').prop('checked',true);
            }else
            {
                $(this).parent('li').parent('ul').siblings('input#account').prop('checked',false);

            }


        })
    })
    
</script>


<script>

    $(function (){
        
        $('input#category').on('change', function(){

            if($(this).is(':checked'))
            {
                $(this).siblings('i').removeClass('si-folder').addClass('si-folder-alt');
                $(this).siblings('ul').find('li').css("display", "block");
                $(this).siblings('ul').find('i').removeClass('si-folder').addClass('si-folder-alt');;
                $(this).siblings('ul').find('input#category, input#last_level_category').prop('checked',true);


            }else
            {
                // $(this).siblings('i').removeClass('si-folder-alt').addClass('si-folder');
                // $(this).siblings('ul').find('li').css("display", "none");
                $(this).siblings('ul').find('input#category, input#last_level_category').prop('checked',false);


            }
            
        })

        $('input#last_level_category').on('change', function(){


            var all_childs = $(this).parent('li').parent('ul').find('input#last_level_category').length;
            var checked_childs = $(this).parent('li').parent('ul').find('input#last_level_category:checked').length;

            if( all_childs === checked_childs)
            {
                $(this).parents('li').find('input#category').prop('checked',true);
            }else
            {
                $(this).parents('li').find('input#category').prop('checked',false);

            }


        })
    })
    
</script>


<script>

    $(function (){
        
        $('input#check_all_accounts').on('change', function(){

            if($(this).is(':checked'))
            {
                $('input#sub_account, input#account').not(".suiiz").prop('checked',true);
                $('input#sub_account, input#account').not(".suiiz").parents('ul').find('i').removeClass('si-plus').addClass('si-minus');
                $('li#sub_account').not(".suiiz").css("display", "block");



            }else
            {
                $('input#sub_account, input#account').not(".suiiz").prop('checked',false);
                $('input#sub_account, input#account').not(".suiiz").parents('ul').find('i').addClass('si-plus').removeClass('si-minus');
                $('li#sub_account').not(".suiiz").css("display", "none");


            }
            
        })
    })
    
</script>


<script>

    $(function (){
        
        $('input[name="type_of_categories"]').on( 'change' ,function() 
        {
            var value = $(this).val();

            if( value == 1 )
            {
                
                $('#recurring_categories').addClass('d-none');
                $('#all_categories').removeClass('d-none');
                $('input[name="last_recurring_category"]').prop('checked',false);

            }else
            {
                $('#recurring_categories').removeClass('d-none');
                $('#all_categories').addClass('d-none');
                // $('input[name="last_categories[]"], input#category').prop('checked',false);


            }
            
        })
    })
    
</script>


<script>

    $(function (){
        
        $('input#sub_account:checked').parent().css("display", "block").siblings().css("display", "block");
        $('input#sub_account:checked').parent().parent().siblings('i').removeClass('si-plus').addClass('si-minus');


        $('input#last_level_category:checked').parents('li').css("display", "block").siblings().css("display", "block");
        $('input#last_level_category:checked').parent().parents().siblings('i').removeClass('si-folder').addClass('si-folder-alt');
    })
    
</script>

<script>

//////////view banner appear text1 and text 2
$( "#view").change(function() 
    {
    var value=$('#view option:selected').html();

    if(value =="banner")
    {
        $('#text_view').css('display','block');

    }
    else
    {
        $('#text_view').css('display','none');

    }
});


$("#image").change(function() 
    {

        $('#image_edit').css('display','none');

      
   });
</script>





@endsection

@push('script')

 <script>
        var uploadedDocumentMap = {}
    Dropzone.options.dpzMultipleFiles = {
        paramName: "dzfile", // The name that will be used to transfer the file
        //autoProcessQueue: false,
        maxFilesize: 5, // MB
        maxFiles: 1,
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
        url: "{{ route('admin.recurring_categories.images.store') }}", // Set the url
        success:
            function (file, response) {
                $('form').append('<input type="hidden" name="document" value="' + response.name + '">')
                
                uploadedDocumentMap[file.name] = response.name
                $('#images').css('display','none');
            }
        ,
        removedfile:function(file)
        {
            
            //file.fid

            $.ajax({
            
                url: "{{ URL::to('admin/delete/image') }}",
                type: "GET",
                dataType: "json",
                data:{_token:'{{ csrf_token() }}',id:file.id
                
                }
            });
            var fmock;
        return (fmock = file.previewElement) != null ? fmock.parentNode.removeChild(file.previewElement):void 0;

        },
        
        init:function(
    
        ){
    
        
                var mock = {name: '{{  $recurring_category->image ? $recurring_category->image : URL::to('/').'/categories/avatar.png' }}',id: '{{ $recurring_category->id }}'};
                this.emit('addedfile',mock);
                this.options.thumbnail.call(this,mock,'{{ url($recurring_category->image ? $recurring_category->image : URL::to('/').'/categories/avatar.png') }}');
        
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

@endpush

