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

    @if(App::getLocale() == 'en')
    <!--Internal  treeview -->
    <link href="{{URL::asset('assets/plugins/treeview/treeview.css')}}" rel="stylesheet" type="text/css" />
    @else
    <!--Internal  treeview -->
    <link href="{{URL::asset('assets/plugins/treeview/treeview-rtl.css')}}" rel="stylesheet" type="text/css" />
    @endif


@section('title')
    {{ trans('lang.page_title_of_recurring_filter') }}
@stop

@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Dashboard</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                الفئات الفرعية</span>
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
                     
                   @can('create_recurring_categories')
                       
                   <a href="{{route('recurring_category.create', $category_type_id)}}" class="btn btn-outline-primary" >اضافة</a>
                   @endcan

                    @can('delete_recurring_categories')
                        <a  href="#" data-toggle="modal" data-target="#delete_all">
                            <i class="btn btn-danger  btn-sm" id="btn_delete_all"  >{{ trans('lang.delete_all') }}</i> &nbsp;&nbsp;
                        </a>
                        
                        <a href="{{route('recurring_category.trash_recurring_category' , 0)}}" class="btn btn-sm btn-danger">
                            Trash
                        </a>
                        
                    @endcan

            </div>

            <div class="modal fade" id="delete_all" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ trans('lang.delete') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <form action="{{route('recurringCategories.DestroyAll')}}" method="post">
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
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'
                        style="text-align: center">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">{{ trans('lang.recurring_filter_name') }}</th>
                                <th class="border-bottom-0">Image</th>
                                <th class="border-bottom-0">View image</th>
                                <th class="border-bottom-0">View name</th>
                                <th class="border-bottom-0">التاريخ</th>
                                <th class="border-bottom-0">{{ trans('lang.action') }}</th>
                                <th><input name="select_all" id="delete_all" type="checkbox" onclick="CheckAll('box1', this)" /></th>

                            </tr>
                        </thead>
                        <tbody id="tablecontents">
                            
                            @foreach ($recurringSubCategories as $recurring_category )

                                <tr data-id="{{ $recurring_category->id }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $recurring_category->name }}</td>
                                    <td><img style="width: 80px;height:60px" src="{{$recurring_category->image}}" alt="categories-image"></td>
                                    <td><img style="width: 80px;height:60px" src="{{optional($recurring_category->view)->image}}" alt="categories-image"></td>
                                    <td>{{ optional($recurring_category->view)->name }}</td>
                                    <td>{{ $recurring_category->created_at }}</td>
                                    <td>
                                        @if( $recurring_category->view->name == 'last_level' )

                                       @else 

                                         <a href="{{route('subRecurringCategories.index', $recurring_category)}}" class="btn btn-sm btn-primary">
                                            <i class="far fa-eye"></i>
                                         </a>
                                       @endif

                                       @can('update_recurring_categories')
                                    
                                       <a href="{{route('recurring_categories.edit',$recurring_category)}}" class="btn btn-sm btn-info"  title="edit"><i class="las la-pen"></i></a> 
                                       @endcan

                                       @can('delete_recurring_categories')
                                        
                                       <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                       data-toggle="modal" href="#modaldemo9{{ $recurring_category->id }}" title="delete">hide</a>
                                       @endcan


                                                
                                    </td>
                                <td><input id="cat-box" type="checkbox" name="view"  value="{{$recurring_category->id}}" class="box1" ></td>

                                </tr>


                          
                                @include('web.admin.recurringSubCategories.delete_modal', ['recurringSubCategory' => $recurring_category])
                                
                                
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    



    </div>

    {{-- @include('web.admin.recurring_filters.add_modal') --}}
    
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
<script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>


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
        $('tr').each(function(index,element) {
          order.push({
            id: $(this).attr('data-id'),
            position: index+1
          });
        });
        
        $.ajax({
          type: "post", 
          dataType: "json", 
          url: "{{ url('admin/sortabledatatable_recurring_category') }}",
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
$('.modal #tree2 li').css("display", "block");
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