@extends('layouts.master')
@section('title')
    {{ trans('product.products') }}
@stop

@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!---Internal  Owl Carousel css-->
    <link href="{{ URL::asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet">
    <!--- Internal Sweet-Alert css-->
    <link href="{{ URL::asset('assets/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <style>
        #sortable {
            list-style-type: none;
            margin: 0;
            padding: 0;
            width: 90%;
        }

        #sortable li {
            margin: 3px 3px 3px 0;
            padding: 1px;
            float: left;
            border: 0;
            background: none;
        }

        #sortable li img {
            width: 180px;
            height: 140px;
        }


        .modal-dialog {
            max-width: 870px;
            margin: 1.75rem auto;
        }


        .image-area {
            position: relative;
            /* width: 50%; */
            background: #333;
        }

        .image-area img {
            max-width: 100%;
            height: auto;
        }

        .remove-image {
            display: none;
            position: absolute;
            top: -10px;
            right: -10px;
            border-radius: 10em;
            padding: 2px 6px 3px;
            text-decoration: none;
            font: 700 21px/20px sans-serif;
            background: #555;
            border: 3px solid #fff;
            color: #FFF;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.5), inset 0 2px 4px rgba(0, 0, 0, 0.3);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
            -webkit-transition: background 0.5s;
            transition: background 0.5s;
        }

        .remove-image:hover {
            background: #E54E4E;
            padding: 3px 7px 5px;
            top: -11px;
            right: -11px;
        }

        .remove-image:active {
            background: #E54E4E;
            top: -10px;
            right: -11px;
        }

        .dataTables_paginate {
            display: none
        }

        #example1_filter {
            display: none;
        }

        #example1_filter {
            display: none;
        }

    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.2/jquery.ui.touch-punch.min.js"></script>

@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('lang.products') }}</h4><span
                    class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    {{ trans('lang.products') }}</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

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


    <!-- row -->
    <div class="row">
        <!--div-->

        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    @if ($products->count())

                        <input type="hidden" value="{{ $products->first()->category_id }}" id="category_id" />
                    @else
                        <input type="hidden" value="0" id="category_id" />
                    @endif

                    @if ($category_parent->parent_id == 0)

                        <a href="{{ route('categories.index') }}" class="btn btn-sm btn-primary" style="color:white">
                            <i></i>&nbsp; {{ trans('lang.back') }}</a>

                    @else

                        <a href="{{ route('category.subCategories', $category_parent->parent_id) }}"
                            class="btn btn-sm btn-primary" style="color:white"><i></i>&nbsp; {{ trans('lang.back') }}</a>

                    @endif

                    @can('delete_product_of_category')
                        <a href="{{ route('product.trash_products_of_catrgory', $category_id) }}"
                            class="btn btn-danger btn-sm">{{ trans('lang.trash') }}</a>
                    @endcan

                    <a href="#" data-toggle="modal" data-target="#finish_all"><i class="btn btn-primary  btn-sm"
                            id="btn_finish_all">finish all </i>&nbsp;&nbsp;
                    </a>

                    <br>
                    <br>

                    @can('create_product_of_category')

                        <a href="{{ route('product.productofcatrgorycreate', $category_id) }}" class="btn btn-sm btn-primary"
                            style="color:white"><i class="fas fa-plus"></i>&nbsp; {{ trans('lang.add_product') }}</a>
                    @endcan

                    <br>
                    <br>

                    @can('delete_product_of_category')
                        <a href="#" data-toggle="modal" data-target="#delete_all"><i class="btn btn-danger  btn-sm"
                                id="btn_delete_all">{{ trans('lang.hide') }}</i>&nbsp;&nbsp;
                        @endcan
                    </a>
                    <br>
                    <br>

                </div>


                <!-- ////////////////////////modela for delete///////////// -->


                <!-- ////////////////////////modela for delete///////////// -->


                <div class="modal fade" id="delete_all" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document" style="width: 870px">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ trans('lang.delete') }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <form action="{{ route('products.delete_all') }}" method="post">
                                    {{ method_field('delete') }}
                                    {{ csrf_field() }}
                            </div>
                            <div class="modal-body">
                                <input class="text" type="hidden" id="delete_all_id" name="delete_all_id"
                                    value=''>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">{{ trans('lang.close') }}</button>
                                <button type="submit" class="btn btn-danger">{{ trans('lang.save') }}</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="modal fade" id="finish_all" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">finish_all</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <form action="{{ route('products.finish_all') }}" method="post">
                                    {{ csrf_field() }}
                            </div>
                            <div class="modal-body">
                                <input class="text" type="hidden" id="finish_all_id" name="finish_all_id"
                                    value=''>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">{{ trans('lang.close') }}</button>
                                <button type="submit" class="btn btn-danger">{{ trans('lang.save') }}</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>


                @if ($products->count())

                    <div style="margin-left:70%">
                        <form class="form-inline" action="{{ route('productOfCategory.search') }}" method="GET">

                            <div class="form-group mx-sm-3">
                                <button type="submit" class="btn btn-primary">بحث</button>

                                <input type="hidden" name="category_id" value="{{ $category_id }}" />
                                <input type="text" class="form-control ml-5" name="query" id="query" placeholder=""
                                    value="{{ request()->input('query') }}" required>

                            </div>
                        </form>
                    </div>
                @endif

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'
                            style="text-align: center">
                            <thead>
                                <tr>
                                    <th><input name="select_all" id="delete_all" type="checkbox"
                                            onclick="CheckAll('box1', this)" /></th>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">{{ trans('lang.product_name') }} </th>
                                    <th class="border-bottom-0">{{ trans('lang.last_categories') }} </th>

                                    <th class="border-bottom-0">Mobile </th>
                                    <th class="border-bottom-0">email </th>

                                    <th class="border-bottom-0">phone</th>
                                    <th class="border-bottom-0">{{ trans('lang.price') }} </th>
                                    <th class="border-bottom-0">{{ trans('lang.quantity') }}</th>
                                    <th class="border-bottom-0">{{ trans('lang.orgniazation') }}</th>
                                    <th class="border-bottom-0">{{ trans('lang.status') }}</th>
                                    <th class="border-bottom-0">{{ trans('lang.action') }}</th>
                                    <th class="border-bottom-0">{{ trans('lang.created_at') }}</th>

                                </tr>
                            </thead>
                            <tbody id="tablecontents">

                                @include('web.admin.products_category.pagination_data')

                                @include('web.admin.products_dashboard.product')

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->
    </div>

    <!-- حذف الفاتورة -->


    <!-- ارشيف الفاتورة -->

    </div>
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
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/rating/ratings.js') }}"></script>
    <!--Internal  Sweet-Alert js-->
    <script src="{{ URL::asset('assets/plugins/sweet-alert/sweetalert.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/sweet-alert/jquery.sweet-alert.js') }}"></script>
    <!-- Sweet-alert js  -->
    <script src="{{ URL::asset('assets/plugins/sweet-alert/sweetalert.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/sweet-alert.js') }}"></script>

    <script src="{{ URL::asset('assets/plugins/treeview/treeview.js') }}"></script>

    <!-- jQuery UI -->
    <script type="text/javascript" src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
        $(document).ready(function() {

            var category_id = $('#category_id').val();

            function clear_icon() {
                $('#id_icon').html('');
                $('#post_title_icon').html('');
            }

            function fetch_data(page, sort_type, sort_by, query) {
                $.ajax({
                    url: "pagination/fetch_data?page=" + page + "&sortby=" + sort_by + "&sorttype=" +
                        sort_type + "&query=" + query + "&category_id=" + category_id,

                    success: function(data) {
                        $('tbody').html('');
                        $('tbody').html(data);
                    }
                })
            }

            $(document).on('keyup', '#serach', function() {
                var query = $('#serach').val();
                var column_name = $('#hidden_column_name').val();
                var sort_type = $('#hidden_sort_type').val();
                var page = $('#hidden_page').val();
                fetch_data(page, sort_type, column_name, query);
            });

            $(document).on('click', '.sorting', function() {
                var column_name = $(this).data('column_name');
                var order_type = $(this).data('sorting_type');
                var reverse_order = '';
                if (order_type == 'asc') {
                    $(this).data('sorting_type', 'desc');
                    reverse_order = 'desc';
                    clear_icon();
                    $('#' + column_name + '_icon').html(
                        '<span class="glyphicon glyphicon-triangle-bottom"></span>');
                }
                if (order_type == 'desc') {
                    $(this).data('sorting_type', 'asc');
                    reverse_order = 'asc';
                    clear_icon
                    $('#' + column_name + '_icon').html(
                        '<span class="glyphicon glyphicon-triangle-top"></span>');
                }
                $('#hidden_column_name').val(column_name);
                $('#hidden_sort_type').val(reverse_order);
                var page = $('#hidden_page').val();
                var query = $('#serach').val();
                fetch_data(page, reverse_order, column_name, query);
            });

            $(document).on('click', '.pagination a', function(event) {
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




    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    <script>
        $(document).ready(function() {

            // Initialize sortable
            $(".modal-body .images #sortable").sortable();


            $('#sort').click(function() {
                var imageids_arr = [];
                // get image ids order
                console.log($('.modal-body .images #sortable li').length);

                $('.modal-body .images #sortable li').each(function() {

                    var id = $(this).data('id');
                    imageids_arr.push(id);
                });

                //   AJAX request
                $.ajax({
                    type: 'post',
                    dataType: "json",
                    url: "{{ url('admin/sort_product_images') }}",
                    data: {

                        imageids: imageids_arr,
                        _token: '{{ csrf_token() }}'

                    },
                    success: function(response) {

                        if (response == 1) {
                            $('.alert-success').empty().html('Sorted Successfuly.')
                            $('.alert-success').removeClass('d-none')

                        } else {
                            $('.alert-danger').empty().html('Error.')
                            $('.alert-danger').removeClass('d-none')

                        }


                    }
                });
            });

        });
    </script>

    <script>
        $(document).on('click', '.remove-image', function() {

            var image_id = $(this).data('image_id');


            //   AJAX request
            $.ajax({
                type: 'post',
                dataType: "json",
                url: "{{ url('admin/delete_product_image') }}",
                data: {

                    image_id: image_id,
                    _token: '{{ csrf_token() }}'
                },
                context: this,
                success: function(response) {


                    if (response == 1) {
                        $(this).parent('.image-area').remove();
                        $('.alert-success').empty().html('Deleted Successfuly.')
                        $('.alert-success').removeClass('d-none')

                    } else {
                        $('.alert-danger').empty().html('Error.')
                        $('.alert-danger').removeClass('d-none')

                    }
                }
            });
        });
    </script>

    <script>
        $(function() {
            $("#btn_finish_all").click(function() {
                var selected = new Array();
                $("#example1 input[type=checkbox]:checked").each(function() {
                    selected.push(this.value);

                });
                if (selected.length > 0) {
                    $('#finish_all').modal('show')
                    $('input[id="finish_all_id"]').val(selected);

                }
            });
        });
    </script>


    <script>
        $(function() {
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
        function CheckAll(className, elem) {
            var elements = document.getElementsByClassName(className);
            var l = elements.length;
            if (elem.checked) {
                for (var i = 0; i < l; i++) {
                    elements[i].checked = true;
                }
            } else {
                for (var i = 0; i < l; i++) {
                    elements[i].checked = false;
                }
            }
        }
    </script>



    <script type="text/javascript">
        $(function() {

            $("#table").DataTable();

            $("#tablecontents").sortable({
                items: "tr",
                cursor: 'move',
                opacity: 0.6,
                update: function() {
                    sendOrderToServer();
                }
            });

            function sendOrderToServer() {

                var order = [];
                $('table .tr').each(function() {
                    var id = $(this).data('id');
                    order.push(id);

                });

                $.ajax({
                    type: "post",
                    dataType: "json",
                    url: "{{ url('admin/product_sortabledatatable') }}",
                    data: {
                        order: order,
                        _token: '{{ csrf_token() }}'
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
        $('#exampleModal2').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var s3 = $('tr.tr').data('s3')

            var modal = $(this)


            if (id) {
                $.ajax({

                    url: "{{ URL::to('admin/product_review') }}/" + id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {

                        $('.modal-body .images #sortable').empty();
                        $('.modal-body .info').empty();
                        $('.modal-header h5').empty();
                        $('.modal-body .filters').empty();

                        $('.modal-header h5').append('<span> <strong> ' + data.product.name.en +
                            '  </strong> </span>');

                            $.each(data.images, function(key, image) {

                            $('.modal-body .images #sortable').append('<li class="ui-state-default image-area" data-id="'+image.id+'" >'+
                                        '<a class="remove-image" href="#" style="display: inline;" data-image_id="'+image.id+'">&#215;</a>'+
                                        '<img src="'+image.medium+'" height="50px" width="50px">'+
                            '</li>');

                            })

                        $('.modal-body .info').append('<span> <strong>  Categories </strong> </span>');

                        $.each(data.categories, function(key, category) {

                            $('.modal-body .info').append('  <span> >> <strong> ' + category +
                                ' </strong>  </span>');

                        });

                        $('.modal-body .info').append(
                            ' <br> <span> <strong>  Price :- </strong> </span>' +
                            '<span>  ' + data.product.price + ' </span> <br>');

                        $('.modal-body .info').append(
                            '<span> <strong>  Description :- </strong> </span>' +
                            '<span>  ' + data.product.description + ' </span> <br>');

                        $('.modal-body .info').append('<span> <strong>  Address :- </strong> </span>' +
                            '<span>  ' + data.governorate_name + ' - ' + data.city_name +
                            ' </span> <br>');





                        $('.modal-body .filters').append('<h5 class="mt-2"> Filters :- </h5>');

                        $.each(data.filters, function(key, filter) {

                            $('.modal-body .filters').append(
                                '  <span style="color:#1435d5">  <strong> ' + filter.name
                                .en + '    </strong> :-&nbsp;&nbsp; </span>');


                            $.each(filter.sub_filters_recurring, function(key, sub_filter) {

                                $('.modal-body .filters').append('  <span>  <strong> ' +
                                    sub_filter.name.en + ' </strong>  </span> <br>');




                            });


                        });




                    },

                });
            } else {
                console.log('AJAX load did not work');
            }

        })
    </script>

@endsection
