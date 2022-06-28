@extends('layouts.master')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!---Internal  Owl Carousel css-->
    <link href="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet">
    <!--- Internal Sweet-Alert css-->
    <link href="{{URL::asset('assets/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


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
    {{ trans('lang.page_title_of_recurring_sub_filter') }}
@stop

@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Dashboard</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
               Recurring Sub Filters</span>
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





<!-- row -->
<div class="row">


    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0">
                    @can('create_recurring_sub_filters')

                    <a class="modal-effect btn btn-outline-primary" data-effect="effect-scale" data-toggle="modal" href="#modaldemo8">{{ trans('lang.add_recurring_sub_filter') }}</a>
                    @endcan
                
                <a href="{{route('recurring_sub_filters.trash_recurring_sub_filter', $recurring_filter_id)}}" class="btn btn-sm btn-danger">
                    Trash
                </a>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'
                        style="text-align: center">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">{{ trans('lang.recurring_filter_name') }}</th>
                                <th class="border-bottom-0">image</th>
                                <th class="border-bottom-0">created_at</th>
                                <th class="border-bottom-0">{{ trans('lang.action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="tablecontents">
                            @foreach ($recurring_sub_filters as $recurring_sub_filter )

                            

                                <tr class='tr' data-id="{{ $recurring_sub_filter->id }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $recurring_sub_filter->name }}</td>
                                    <td><img style="width: 80px;height:60px" src="{{env('AWS_S3_URL').'/'.'uploads/RecuringSubFilter'}}/{{$recurring_sub_filter->image}}" alt="categories-image"></td>
                                    <td>{{ $recurring_sub_filter->created_at }}</td>

                                    <td>
                                        
                                        
                                    @can('update_recurring_sub_filters')  
                                    <a class="btn btn-sm btn-info" data-effect="effect-scale"
                                    href="{{route('recurring_sub_filters.edit',$recurring_sub_filter->id)}}" title="edit"><i class="las la-pen"></i></a> 
                                    @endcan

                                  @can('delete_recurring_sub_filters')
                                    <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                    data-toggle="modal" href="#modaldemo9{{ $recurring_sub_filter->id }}" title="delete"><i
                                    class="las la-trash"></i></a>
                                  @endcan
                                  
                                    </td>
                                </tr>

                                @include('web.admin.recurring_sub_filters.delete_modal', ['recurring_sub_filter' => $recurring_sub_filter])

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    
        @include('web.admin.recurring_sub_filters.add_modal', ['recurring_filter_id' => $recurring_filter_id])



    </div>

    
    <!-- delete -->
    



    <!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>


<!--Internal  Datatable js -->
<script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
<script src="{{ URL::asset('assets/js/modal.js') }}"></script>


<!--Internal  Datepicker js -->
<script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!-- Internal Select2 js-->
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/rating/ratings.js')}}"></script>
<!--Internal  Sweet-Alert js-->
<script src="{{URL::asset('assets/plugins/sweet-alert/sweetalert.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/sweet-alert/jquery.sweet-alert.js')}}"></script>
<!-- Sweet-alert js  -->
<script src="{{URL::asset('assets/plugins/sweet-alert/sweetalert.min.js')}}"></script>
<script src="{{URL::asset('assets/js/sweet-alert.js')}}"></script>
<!-- jQuery UI -->
<script type="text/javascript" src="//code.jquery.com/ui/1.12.1/jquery-ui.js" ></script>

<script>
    $('#modaldemo9').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var section_name = button.data('section_name')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #section_name').val(section_name);
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
       url: "{{ route('admin.recurring_sub_filters.images.store') }}", // Set the url
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
///for edit_modal
    $("#image").change(function() 
    {
    
        $('#image_edit').css('display','none');
      
    });
</script>


<script type="text/javascript">

    $(function () {
        
      $("#table").DataTable();
    
      $( "#tablecontents" ).sortable({
        items: "tr",
        cursor: 'move',
        opacity: 0.6,
        update: function() {
            sendOrderToServer();
        }
      });
    
      function sendOrderToServer() {
    
        var order = [];
        $('table .tr').each(function(){
            var id = $(this).data('id');
            order.push(id);

        });
    
        $.ajax({
          type: "post", 
          dataType: "json", 
          url: "{{ url('admin/sub_filter_sortabledatatable') }}",
          data: {
            order:order,
            _token: '{{csrf_token()}}'
          },
          success: function(response) {
              if (response.status == "success") {
                console.log(response);
              } else {
                console.log(response);
              }
          }
        });
    
      }
    });
    
</script>

@endpush