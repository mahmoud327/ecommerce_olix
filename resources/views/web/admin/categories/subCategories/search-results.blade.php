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
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">

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

        <style>
            .modal effect-scale
            {
                padding-right:400px;

            }

        </style>

@section('title')
    Category - Page
@stop

@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Dashboard</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
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
                <div>
                       

                    <div class="text-center"style="display: inline; margin-left:20%;">

                        <a   href="{{route('categories.index')}}"  > Parents Categories</a>

                    </div>


                </div>

            </div>

            <div class="modal fade" id="delete_all" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">{{ trans('lang.delete') }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <form action="{{route('categories.delete_all')}}" method="post">
                                        @method('delete')
                                        @csrf
                                </div>
                                <div class="modal-body">
                                    <input class="text" type="hidden" id="delete_all_id" name="delete_all_id" value=''>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('lang.close') }}</button>
                                    <button type="submit" class="btn btn-danger">حذف</button>
                                </div>
                                </form>
                            </div>
                        </div>
             </div>

             @if($subCategories->count())
                  
                  <div  style="margin-left:70%" > 
                  <form class="form-inline" action="{{ route('search_subCategories') }}" method="GET">
                      
                      <div class="form-group mx-sm-3">
                          <button type="submit" class="btn btn-primary">بحث</button>
                          <input type="hidden" name=" " value="{{$subCategories->first()->parent_id}}" id="parent_id"/>
                          <input type="text" class="form-control ml-5" name="query" id="query" 
                           placeholder="" value="{{ request()->input('query') }}" required>
                      </div>
                  </form>
              </div>
           @endif

            <div class="card-body">

                <div class="table-responsive">
                    <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'style="text-align: center"
                        style="text-align: center">
                        <thead >
                            <tr >
                                <th  width="5%"><input name="select_all" id="delete_all" type="checkbox" onclick="CheckAll('box1', this)" /></th>

                                <th width="5%" class="sorting" data-sorting_type="asc" data-column_name="id" style="cursor: pointer">itreation <span id="id_icon"></span></th>
                                <th width="20%" class="sorting" data-sorting_type="asc" data-column_name="post_title" style="cursor: pointer">name <span id="post_title_icon"></span></th>
                                <th width="20%" class="sorting" data-sorting_type="asc" data-mobile_name="mobile" style="cursor: pointer">Image <span id="mobile_icon"></span></th>
                                <th width="10%" class="sorting" data-sorting_type="asc" data-mobile_name="mobile" style="cursor: pointer">View image <span id="mobile_icon"></span></th>
                                <th width="10%" class="sorting" data-sorting_type="asc" data-mobile_name="mobile" style="cursor: pointer">View name <span id="mobile_icon"></span></th>
                                <th width="80%" class="sorting" data-sorting_type="asc" data-mobile_name="mobile" style="cursor: pointer">action <span id="mobile_icon"></span></th>
                                <th width="80%" class="sorting" data-sorting_type="asc" data-mobile_name="mobile" style="cursor: pointer">created_at <span id="mobile_icon"></span></th>
                            </tr>
                        </thead>
                        <tbody id="tablecontents">
                            @include('web.admin.categories.subCategories.pagination_data')

                        </tbody>
                    </table>
                    <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
                    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="id" />
                    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
                    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
                </div>
            </div>
        </div>







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

<script src="{{URL::asset('assets/js/form-elements.js')}}"></script>
<script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>

<!-- jQuery UI -->
<script type="text/javascript" src="//code.jquery.com/ui/1.12.1/jquery-ui.js" ></script>
<script>
    $(document).ready(function(){

     var parent_id=$('#parent_id').val();
     function clear_icon()
     {
      $('#id_icon').html('');
      $('#post_title_icon').html('');
     }

     function fetch_data(page, sort_type, sort_by, query)
     {
      $.ajax({
       url:"search_subCategories/pagination/fetch_data?page="+page+"&sortby="+sort_by+"&sorttype="+sort_type+"&parent_id="+parent_id,

       success:function(data)
       {
        $('tbody').html('');
        $('tbody').html(data);
       }
      })
     }

     $(document).on('keyup', '#serach', function(){
      var query = $('#serach').val();
      var column_name = $('#hidden_column_name').val();
      var sort_type = $('#hidden_sort_type').val();
      var page = $('#hidden_page').val();
      fetch_data(page, sort_type, column_name, query);
     });

     $(document).on('click', '.sorting', function(){
      var column_name = $(this).data('column_name');
      var order_type = $(this).data('sorting_type');
      var reverse_order = '';
      if(order_type == 'asc')
      {
       $(this).data('sorting_type', 'desc');
       reverse_order = 'desc';
       clear_icon();
       $('#'+column_name+'_icon').html('<span class="glyphicon glyphicon-triangle-bottom"></span>');
      }
      if(order_type == 'desc')
      {
       $(this).data('sorting_type', 'asc');
       reverse_order = 'asc';
       clear_icon
       $('#'+column_name+'_icon').html('<span class="glyphicon glyphicon-triangle-top"></span>');
      }
      $('#hidden_column_name').val(column_name);
      $('#hidden_sort_type').val(reverse_order);
      var page = $('#hidden_page').val();
      var query = $('#serach').val();
      fetch_data(page, reverse_order, column_name, query);
     });

     $(document).on('click', '.pagination a', function(event){
      event.preventDefault();
      var page = $(this).attr('href').split('page=')[1];
      $('#hidden_page').val(page);
      var column_name = $('#hidden_column_name').val();
      var sort_type = $('#hidden_sort_type').val();

      var query = $('#serach').val();

      $('li').removeClass('active');
            $(this).parent().addClass('active');
      fetch_data(page, sort_type, column_name, query);
     });

    });
    </script>


<script>

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
          url: "{{ url('admin/sortabledatatable') }}",
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


<script>
    ///////for add modal
    $(function ()
     {
       $('input#account, input#sub_account,#check_all_accounts').prop('checked',true);
        $('li#sub_account').css("display", "block");;

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
    ///////////////for edit modal
     $(function (){

             $('input#account_edit,#check_all_accounts_edit').prop('checked',true);
                $('li#sub_account_edit').css("display", "block");

            $('input#account_edit').on('change', function(){
                if($(this).is(':checked'))
                {
                    $(this).siblings('i').removeClass('si-plus').addClass('si-minus');
                    $(this).siblings('ul').find('li').css("display", "block");
                    $(this).siblings('ul').find('input#sub_account_edit').prop('checked',true);
                }else
                {
                    // $(this).siblings('i').addClass('si-plus').removeClass('si-minus');
                    // $(this).siblings('ul').find('li').css("display", "none");
                    $(this).siblings('ul').find('input#sub_account_edit').prop('checked',false);
                }

            })
        })

    </script>

    <script>

        $('input#sub_account_edit').on('change', function(){

            var all_childs = $(this).parent('li').parent('ul').find('input#sub_account_edit').length;
            var checked_childs = $(this).parent('li').parent('ul').find('input#sub_account_edit:checked').length;
            if( all_childs === checked_childs)
            {
                $(this).parent('li').parent('ul').siblings('input#account_edit').prop('checked',true);
            }
            else
            {
                $(this).parent('li').parent('ul').siblings('input#account_edit').prop('checked',false);
            }

        });

    </script>


    <script>
        $(function (){

            $('input#check_all_accounts_edit').on('change', function(){
                if($(this).is(':checked'))
                {
                    $('input#sub_account_edit, input#account_edit').not(".suiiz").prop('checked',true);
                    $('input#sub_account_edit, input#account_edit').not(".suiiz").parents('ul').find('i').removeClass('si-plus').addClass('si-minus');
                    $('li#sub_account_edit').not(".suiiz").css("display", "block");
                }else
                {
                    $('input#sub_account_edit, input#account_edit').not(".suiiz").prop('checked',false);
                    $('input#sub_account_edit, input#account_edit').not(".suiiz").parents('ul').find('i').addClass('si-plus').removeClass('si-minus');
                    $('li#sub_account_edit').not(".suiiz").css("display", "none");
                }

            })
        })


    </script>


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
<script>
    $(function()
        {
        $("#btn_delete_all").click(function() {
            var selected = new Array();
            $("#example1 input[type=checkbox]:checked").each(function() {
                selected.push(this.value);

            });
            if (selected.length > 0) {
                $('#delete_all').modal('show')
                $('input[id="delete_all_id"]').val(selected);
            }
        });
        });

</script>


<script>
    function CheckAll(className, elem)
    {
    var elements = document.getElementsByClassName(className);
    var l = elements.length;
    if (elem.checked)
    {
        for (var i = 0; i < l; i++)
        {
            elements[i].checked = true;
        }
    }
    else
    {
        for (var i = 0; i < l; i++)
        {
            elements[i].checked = false;
        }
    }
    }
</script>


@endsection
@push('script')

<script>

    $("#image input").change(function()
    {

        $('#image_edit  ').css('display','none');

    });
       </script>

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
       url: "{{ route('admin.categories.images.store')}}", // Set the url
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




