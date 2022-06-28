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


@endsection
@section('page-header')
            <!-- breadcrumb -->
            <div class="breadcrumb-header justify-content-between">
                <div class="my-auto">
                    <div class="d-flex">
                        <h4 class="content-title mb-0 my-auto">لوحة التحكم</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ انشاء فئة فرعية</span>
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

                @if (session()->has('Add'))

                    <div class="col-lg-12 col-md-12">
                        <!--Page Widget Error-->
                        <div class="card bd-0 mg-b-20 bg-success-transparent alert p-0">
                            <div class="card-header text-success font-weight-bold">
                                <i class="far fa-check-circle"></i> Success Data
                                <button aria-label="Close" class="close" data-dismiss="alert" type="button"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="card-body text-success">
                                <strong>Well done!</strong> {{ session()->get('Add') }}
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

                                <form class="parsley-style-1" id="selectForm2" autocomplete="off" name="selectForm2" action="{{route('subRecurringCategories.store',$subRecurringSubCategory)}}" enctype="multipart/form-data"   method="post">

                                    {{csrf_field()}}

                                    <div class="row">

                                        <div class="col-lg-4">
                        
                                                <br>
                                                
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="name_en"  value="{{old('name_en')}}"  placeholder="English name ">
                                                </div> 
                
                                                <div class="form-group">
                                                    
                                                    <textarea class="form-control" name="description_en"  rows="3" placeholder="English description">{{old('description_en') }}</textarea>
                                                </div>
                
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="name_ar"  value="{{old('name_ar')}}"  placeholder="Arabic name ">
                                                </div>
                                            
                                                <div class="form-group">
                                                    <textarea class="form-control" name="description_ar" placeholder="Arabic description" rows="3">{{old('description_ar') }}</textarea>
                                                </div>

                                        
                                                
                                                <div class="form-group">

                                                    <select class="form-control select2"  name="view_id"  id="view1">
                                                        <option label="Views"></option>
                                                        
                                                        @foreach($views as $view) 
                                                
                                                            @if ($subRecurringSubCategory->view->name == "banner") 
            
                                                                @if ($view->name != "banner" )
                                                                    
                                                                    <option value="{{$view->id}}"  {{ ( $view->name == $last_view) ? 'selected' : '' }}  >{{$view->name}}</option>
                                                                @endif
            
                                                            @else
            
                                                            <option value="{{$view->id}}"  {{ ( $view->name == $last_view) ? 'selected' : '' }}  >{{$view->name}}</option>
            
                                                            @endif
                                                    @endforeach 
                                                    </select>
                                                </div>

                                                       @if ($parent->first()->view()->first()->name =="banner")

                                                            <div  id="text_view1">
                                                                        <div class="form-group">
                                                                            <input type="text" class="form-control" name="text1_ar"   value="{{old('text1_ar')}}"  placeholder="Arabic text 1">
                                                                        </div>

                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" name="text1_en"   value="{{old('text1_en')}}"  placeholder="English text 1">
                                                                    </div>

                                                                    <div class="form-group"> 
                                                                        <input type="text" class="form-control" name="text2_ar" value="{{old('text2_ar')}}" placeholder="Arabic text 2">
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" name="text2_en"  value="{{old('text2_en')}}"placeholder="English text 2">
                                                                    </div>  
                                                            </div>

                                                      @endif
                                            <div id="image" class="form-group"  >
                                                    <div class="custom-file">
                                                        <input class="custom-file-input" name="image" value="" type="file"> <label class="custom-file-label" for="customFile">Choose image</label>
                                                    </div>
                                            </div>

                                        </div>

                                        
                                        
                                        <div class="col-lg-6 m-3">

                                            <div class="row mg-t-10">
                                                <div class="col-lg-3">
                                                    {{-- <label class="rdiobox"><input  name="type_of_categories" value="1" type="radio" checked> <span>All Categories</span></label> --}}
                                                </div>
                                                <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                                    {{-- <label class="rdiobox"><input name="type_of_categories" value="2" type="radio"> <span>Recurring Categories</span></label> --}}
                                                </div>

                                            </div>

                                            <label> انواع الحسابات: </label>
                                            <div id="all_categories">


                                                <input type="checkbox" id="check_all_accounts" class="m-2"><span>كل انواع الحسابات</span>
                                                
                                                <ul id="tree2" >

                                                    @foreach ($accounts as $account)
                                                    
                                                        <li id="account"><input id="account" @if ( $account->name == 'suiiz') checked  onclick="return false;" class="suiiz"  @endif type="checkbox"  style="margin:3px"><a href="#">{{$account->name}}</a>
                                                            
                                                            <ul>
                                                                @foreach ($account->subAccounts()->get() as $sub_account)
                                                        
                                                                    <li id="sub_account" >
                                                                        
                                                                        <input id="sub_account" @if ( $sub_account->name == 'suiiz') checked  onclick="return false;" class="suiiz" @endif  type="checkbox" style="margin:3px"  name="sub_account[]" value="{{$sub_account->id}}" class="m-2">{{$sub_account->name}}
                                                                        
                                                                    </li>

                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    @endforeach

                                                </ul>
                                            </div>

                                        </div>

                                        


                                        <div class="col-lg-12 mt-5 text-center">
                                            <button type="submit" class="btn btn-primary">حفظ</button>

                                        </div>



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


<script>

    $(function (){
        $('input#account, input#sub_account,#check_all_accounts').prop('checked',true);
        $('li#sub_account').css("display", "block");
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
                $(this).siblings('i').removeClass('si-folder-alt').addClass('si-folder');
                $(this).siblings('ul').find('li').css("display", "none");
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

    $(function ()
    {
        
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
      ///////////view banner change show text for create modal   

$("#view").change(function() 
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
    ////////////////create image dropzone for recueing
    var uploadedDocumentMap = {}
   Dropzone.options.dpzMultipleFiles = {
       paramName: "dzfile", // The name that will be used to transfer the file
       //autoProcessQueue: false,
       maxFilesize: 6,
       maxFiles: 1,
       autoQueue:true,

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
               "{{ csrf_token() }}"
       }
       ,
       url: "{{ route('admin.sub_recurring_categories.images.store') }}", // Set the url
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

    
@endpush