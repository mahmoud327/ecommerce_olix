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
								<form class="form-horizontal" method="post" action="{{route('recurring_filters.store')}}">
                                    @csrf
                                    <div class="row">

                                        <div class="col-lg-4">

                                                <div class="form-group">
                                                    <label> Name Of Filter: </label>
                                                    <input type="text" name="name_en" value="{{old('name_en')}}" class="form-control" class="inputName" placeholder="Name in English">
                                                    <br>
                                            
                                                    <input type="text" name="name_ar" value="{{old('name_ar')}}" class="form-control" class="inputName" placeholder="Name in Arabic">
                                                </div>
                                                
                                                <input type="hidden" name="filter_type_id" value="{{$filter_type_id}}" class="form-control">
                                             
                                        </div>
                                        
                                        
                                        <div class="col-lg-8">

                                            <div class="row mg-t-10">

                                                <div class="col-lg-4">

                                                    <label class="rdiobox"><input  name="type_of_categories" value="1" type="radio" checked> <span>All Categories</span></label>
                                                    <br>
                                                    <div id="all_categories">
                                                        <label>Category :</label>
                                                        
                                                        <ul id="tree2" >
                                                            @foreach ($parent_categories as $category)
                                                                <li> 
        
                                                                    @if ( $category->view->id == $last_level_id )
                                                                    <input class="last_level_category" type="checkbox" name="last_categories[]" value="{{$category->id}}" class="m-2">
        
                                                                    @else
                                                                    <input data-id="{{ $category->id}}"  class="category" type="checkbox" class="m-2">
        
                                                                    @endif
        
                                                                    <a href="#" data-id="{{ $category->id}}" @if ( $category->view->id == $last_level_id  ) style="background-color:#229dff;color:#FFF;padding: 0px 10px;"@endif>{{$category->name}}</a>
        

                                                                     @if ( $category->childs()->count() )
                                                                        @include('web.admin.recurring_filters.tree_category', ['categories'   => $category->childs() , 'last_level_id' => $last_level_id ])
                                                                    @endif 
                                                                    
                                                                </li>
                                                            @endforeach
                                                        </ul>

                                                      </div>


                                                </div>

                                                <div class="col-lg-4 mg-t-20 mg-lg-t-0">

                                                    <label class="rdiobox"><input name="type_of_categories" value="2" type="radio"> <span>Recurring Categories</span></label>                       
                                                    <br>

                                                    <div id="recurring_categories" class="d-none">
                                                        <ul id="tree3" >
                                                            @foreach ($recurring_categories as $recurring_category)
                                                                <li> 
        
                                                                    @if ($recurring_category->view->name == 'last_level'  )
                                                                    <input class="last_level_recurring_category" type="checkbox" name="last_recurring_categories[]" value="{{$recurring_category->id}}" class="m-2">
        
                                                                    @else
                                                                    <input class="recurring_category" type="checkbox" class="m-2">
        
                                                                    @endif
        
                                                                    <a href="#" @if ( $recurring_category->view->name == 'last_level' ) style="background-color:#229dff;color:#FFF;padding: 0px 10px;"@endif>{{$recurring_category->name}}</a>
        
                                                                    @if ( $recurring_category->recurringChilds()->count() )
                                                                        @include('web.admin.recurring_filters.tree_recurring_category', ['recurring_categories'   => $recurring_category->recurringChilds()])
                                                                    @endif
                                                                    
                                                                </li>
                                                            @endforeach
        
                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>



                                            <div class="form-group col-md-8">
                                                <h4 class="form-section"><i class="ft-home"></i> {{ trans('lang.image') }}</h4>

                                                <div id="dpz-multiple-files" class="dropzone dropzone-area">
                                                    <div class="dz-message">  {{ trans('lang.uploads') }} </div>
                                                </div>

                                            </div>
                                                

                                    
                                        

                                        <div class="col-lg-12 mt-4 text-center">
                                            <button type="submit" class="btn btn-primary">Save</button>

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


        
        $('input.account, input.sub_account,.check_all_accounts').prop('checked',true);
        $('li.sub_account').css("display", "block");

        
        $('input.account').on('change', function(){

            if($(this).is(':checked'))
            {
                $(this).siblings('i').removeClass('si-plus').addClass('si-minus');
                $(this).siblings('ul').find('li').css("display", "block");
                $(this).siblings('ul').find('input.sub_account').prop('checked',true);


            }else
            {
                // $(this).siblings('i').addClass('si-plus').removeClass('si-minus');
                // $(this).siblings('ul').find('li').css("display", "none");
                $(this).siblings('ul').find('input.sub_account').prop('checked',false);


            }
            
        })
        
        $('input.sub_account').on('change', function(){


            var all_childs = $(this).parent('li').parent('ul').find('input.sub_account').length;
            var checked_childs = $(this).parent('li').parent('ul').find('input.sub_account:checked').length;

            if( all_childs === checked_childs)
            {
                $(this).parent('li').parent('ul').siblings('input.account').prop('checked',true);
            }else
            {
                $(this).parent('li').parent('ul').siblings('input.account').prop('checked',false);

            }


        })



    })
    
</script>


{{-- categories checker --}}
<script>

    $(function (){
        
        $('input.category').on('change', function(){

            if($(this).is(':checked'))
            {
                $(this).siblings('i').removeClass('si-folder').addClass('si-folder-alt');
                $(this).siblings('ul').find('li').css("display", "block");
                $(this).siblings('ul').find('i').removeClass('si-folder').addClass('si-folder-alt');
                $(this).siblings('ul').find('input.category, input.last_level_category').prop('checked',true);


            }else
            {
                $(this).siblings('i').removeClass('si-folder-alt').addClass('si-folder');
                $(this).siblings('ul').find('li').css("display", "none");
                $(this).siblings('ul').find('input.category, input.last_level_category').prop('checked',false);


            }
            
        })


        // $('input.last_level_category').on('change', function(){


        //     var all_childs = $(this).parent('li').parent('ul').find('input.last_level_category').length;
        //     var checked_childs = $(this).parent('li').parent('ul').find('input.last_level_category:checked').length;

        //     if( all_childs === checked_childs)
        //     {
        //         $(this).parents('li').find('input.category').prop('checked',true);
        //     }else
        //     {
        //         $(this).parents('li').find('input.category').prop('checked',false);

        //     }


        // })
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
                $('input[name="last_categories[]"], input#category').prop('checked',false);


            }
            
        })
    })
    
</script>



<script>

    $(function (){
        
        $('input.recurring_category').on('change', function(){

            if($(this).is(':checked'))
            {
                $(this).siblings('i').removeClass('si-arrow-down-circle').addClass('si-arrow-right-circle');
                $(this).siblings('ul').find('li').css("display", "block");
                $(this).siblings('ul').find('i').removeClass('si-arrow-down-circle').addClass('si-arrow-right-circle');;
                $(this).siblings('ul').find('input.recurring_category, input.last_level_recurring_category').prop('checked',true);


            }else
            {
                $(this).siblings('i').removeClass('si-arrow-right-circle').addClass('si-arrow-down-circle');
                $(this).siblings('ul').find('li').css("display", "none");
                $(this).siblings('ul').find('input.recurring_category, input.last_level_recurring_category').prop('checked',false);


            }
            
        })


        $('input.last_level_recurring_category').on('change', function(){


            var all_childs = $(this).parent('li').parent('ul').find('input.last_level_recurring_category').length;
            var checked_childs = $(this).parent('li').parent('ul').find('input.last_level_recurring_category:checked').length;

            if( all_childs === checked_childs)
            {
                $(this).parents('li').find('input.recurring_category').prop('checked',true);
            }else
            {
                $(this).parents('li').find('input.recurring_category').prop('checked',false);

            }


        })
    })
    
</script>


@endsection

@push('script')
<script>
    var uploadedDocumentMap = {}
   Dropzone.options.dpzMultipleFiles = {
       paramName: "dzfile", // The name that will be used to transfer the file
     
       maxFiles:1,
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
       url: "{{ route('admin.recurring_filters.images.store') }}", // Set the url
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
