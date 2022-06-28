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
               Recurring Filters </span>
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
                    @can('create_recurring_filter')      
                       <a href="{{route('recurring_filter.create', $filter_type_id)}}" class="btn btn-outline-primary" >{{ trans('lang.add_recurring_filter') }}</a>
                    @endcan


                    <a href="{{route('recurring_filters.trash_recurring_filter', $filter_type_id)}}" class="btn btn-sm btn-danger">
                        Trash
                    </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='1000'
                        style="text-align: center">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">{{ trans('lang.recurring_filter_name') }}</th>
                                <th class="border-bottom-0">image</th>
                                <th class="border-bottom-0">Type</th>

                                <th class="border-bottom-0">code</th>
                         
                                <th class="border-bottom-0">{{ trans('lang.action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="tablecontents">
                            @foreach ($recurring_filters as $recurring_filter )

                                <tr class='tr' data-id="{{ $recurring_filter->id }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $recurring_filter->name }}</td>
                                    <td><img style="width: 80px;height:60px" src="{{env('AWS_S3_URL').'/'.'uploads/RecuringFilter'}}/{{$recurring_filter->image}}" alt="categories-image"></td>
                                    <td>@if(in_array($recurring_filter->id , $filters_ids)) New  @else ------ @endif</td>
                                    <td>{{ $recurring_filter->id }}</td>

                                    <td>

                                        @can('update_recurring_filter')
                                            
                                        <a href="{{route('recurring_filters.edit', $recurring_filter->id )}}" class="btn btn-sm btn-info"  title="edit"><i class="las la-pen"></i></a> 
                                        @endcan

                                            <a href="{{route('recurring_sub_filters', $recurring_filter->id )}}" class="btn btn-sm btn-info"  title="edit"><i class="las la-eye"></i></a> 
                                        @can('delete_recurring_filter')
                                            
                                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                        data-toggle="modal" href="#modaldemo9{{ $recurring_filter->id }}" title="delete"><i
                                        class="las la-trash"></i></a>
                                        @endcan

                                    </td>
                                </tr>

                                @include('web.admin.recurring_filters.delete_modal', ['recurring_filter' => $recurring_filter])
                                
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
          url: "{{ url('admin/filter_sortabledatatable') }}",
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


@endsection