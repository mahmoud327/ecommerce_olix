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
@section('title')
    admins - Page
@stop

@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Dashboard</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                admins </span>
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

                <div class="">
                    @can('create_admin')
                        <a class="btn btn-outline-primary"
                        href="{{route('admins.create')}}">Add Admin </a>
                    @endcan
                   
                 </div>
                <br>
              @can('delete_all_admin')

                 <a  href="#"
                    data-toggle="modal" data-target="#delete_all"><i
                    class="btn btn-danger  btn-sm" id="btn_delete_all"  >delete all</i>&nbsp;&nbsp;
                </a>
                    
                
                <div class="modal fade" id="delete_all" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">delete</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <form action="{{route('admins.delete_all') }}" method="post">
                                    {{ method_field('delete') }}
                                    {{ csrf_field() }}
                            </div>
                            <div class="modal-body">
                                <input class="text" type="hidden" id="delete_all_id" name="delete_all_id" value=''>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                <button type="submit" class="btn btn-danger">تاكيد</button>
                            </div>
                            </form>
                        </div>
                    </div>
                    </div>
    



                </div>
            @endcan
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'
                        style="text-align: center">
                        <thead>
                            <tr>
                                <th><input name="select_all" id="delete_all" type="checkbox" onclick="CheckAll('box1', this)" /></th>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">image</th>
                                <th class="border-bottom-0">name</th>
                                <th class="border-bottom-0">email</th>
                                <th class="border-bottom-0">phone</th>
                                <th class="border-bottom-0">action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admins as $admin )

                            

                                <tr>
                                    <td><input id="cat-box" type="checkbox" name="admins"  value="{{$admin->id}}" class="box1" ></td>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><img style="width: 80px;height:60px" src="{{ env('AWS_S3_URL').'/'. $admin->image}}" alt="admin-image"></td>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>{{ $admin->phone }}</td>
                                    <td>
                                        @can('activate_admin')
                                            @if($admin->activate)
                                                <a href="{{url(route('admins.deactivate',$admin->id))}}"
                                                class="btn btn-sm btn btn-danger">إلغاء التفعيل</a>
                                                @else
                                                    <a href="{{url(route('admins.activate',$admin->id))}}"
                                                    class="btn btn-sm btn btn-success">تفعيل</a>
                                                @endif
                                        @endcan

                                        @can('update_admin')     
                                            <a class="btn btn-sm btn-info"
                                                href="{{route('admins.edit',$admin->id)}}" title="edit"><i class="las la-pen"></i></a> 
                                         @endcan

                                         @can('delete_admin') 
                                         <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                         data-toggle="modal" href="#modaldemo9{{ $admin->id }}" title="delete"><i
                                         class="las la-trash"></i></a>
                                         @include('web.admin.admins.delete_modal' ,['admin'=>$admin])

                                         @endcan
                                        


                                    </td>
                                </tr>

                            
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    



    </div>

    @include('web.admin.features.add_modal')
    
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

@push('script')


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
@endpush

@endsection