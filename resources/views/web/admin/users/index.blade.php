 @extends('layouts.master')
@section('title')
users
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

        .dataTables_paginate
        {
            display:none
        }

        #example1_filter{
            display: none;
        }
        #example1_filter
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
                <h4 class="content-title mb-0 my-auto">users</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                   users</span>
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
                <div class="card-header pb-0">.
                 @can('send_notification')

                    <a  href="#" data-user_id=""
                        data-toggle="modal" data-target="#send_notifications"><i
                            class="btn btn-primary"  >send notification</i>
                    </a>

                    <div class="modal fade" id="send_notifications" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">send notification</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    
                                </div>
                                <div class="modal-body">
            
                                    <form action="{{route('users.send_notification_all_users')}}" method="post" enctype="multipart/form-data">
                                        {{ csrf_field()}}
                    
                                        <div class="form-group"id="lnWrapper">
                                            <label>title arabic: <span class="tx-danger">*</span></label>
                                            <input class="form-control" data-parsley-class-handler="#lnWrapper"
                                            name="title_ar" placeholder="Arabic name"   >
                                        </div>
                                        <div class="form-group"id="lnWrapper">
                                            <label>title english: <span class="tx-danger">*</span></label>
                                            <input class="form-control" data-parsley-class-handler="#lnWrapper"
                                            name="title_en" placeholder="english title"   >
            
                                            
                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">content arabic</label>
                                            <textarea type="text" class="form-control"  id="content_ar" name="content_ar" placeholder="content arabic" > </textarea>
                                        </div>
            
                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">content english</label>
                                            <textarea type="text" class="form-control"  id="content_en" name="content_en" placeholder="content english" > </textarea>
                                        </div>
                                    
                                    
                    
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">تاكيد</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                                        </div>
                                    </form>
                                </div>
                    
                        
                            
                            </div>
                        </div>
                    </div> 
                @endcan
                 @can('delete_all_user')

             

                    <div class="modal fade" id="delete_all" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">{{ trans('lang.delete') }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <form action="{{route('users.delete_all') }}" method="post">
                                        {{ method_field('delete') }}
                                        {{ csrf_field() }}
                                </div>
                                <div class="modal-body">
                                    <input class="text" type="hidden" id="delete_all_id" name="delete_all_id" value=''>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('lang.close') }}</button>
                                    <button type="submit" class="btn btn-danger">{{ trans('lang.save') }}</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                 @endcan


                <br>
                <br>




                </div>
                 <div  style="margin-left:80%" >

                        <div class="col-sm-10">
                           <input type="text" name="serach" id="serach" class="form-control" />
                        </div>
                   </div>

                <div class="card-body">

                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'style="text-align: center">
                            <thead>
                                <tr>
                                    <th  width="5%"><input name="select_all" id="delete_all" type="checkbox" onclick="CheckAll('box1', this)" /></th>
                                    <th width="5%" class="sorting" data-sorting_type="asc" data-column_name="id" style="cursor: pointer">ID <span id="id_icon"></span></th>
                                    
                                    <th width="20%" class="sorting" data-sorting_type="asc" data-column_name="post_title" style="cursor: pointer">name <span id="post_title_icon"></span></th>
                                    <th width="20%">email</th>
                                    <th width="20%" class="sorting" data-sorting_type="asc" data-mobile_name="mobile" style="cursor: pointer">mobile <span id="mobile_icon"></span></th>
                                    <th width="10%" class="sorting" data-sorting_type="asc" data-mobile_name="mobile" style="cursor: pointer">points <span id="mobile_icon"></span></th>
                                    <th width="10%" class="sorting" data-sorting_type="asc" data-mobile_name="mobile" style="cursor: pointer">countOfProducts <span id="mobile_icon"></span></th>
                                    <th width="10%" class="sorting" data-sorting_type="asc" data-mobile_name="mobile" style="cursor: pointer">action <span id="mobile_icon"></span></th>
                                    <th width="40%" class="sorting" data-sorting_type="asc" data-mobile_name="mobile" style="cursor: pointer">created_at <span id="mobile_icon"></span></th>

                                </tr>
                            </thead>
                            <tbody>
                                @include('web.admin.users.pagination_data')

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




{{-- <script>
    $(document).ready(function() {
  $('#search').on('change', function() {
     document.forms[myFormName].submit();
  });
});
</script> --}}
<script>
    $(document).ready(function(){

     function clear_icon()
     {
      $('#id_icon').html('');
      $('#post_title_icon').html('');
     }

     function fetch_data(page, sort_type, sort_by, query)
     {
      $.ajax({
       url:"/pagination/fetch_data?page="+page+"&sortby="+sort_by+"&sorttype="+sort_type+"&query="+query,
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
<script>
$(function ()
{
    $('li#sub_account').css("display", "block");

});

</script>
<script>

    $(function (){

        $('input#check_all_accounts').on('change', function(){
            if($(this).is(':checked'))
            {
                $('input#sub_account, input#account').not(".personal").prop('checked',true);
                $('input#sub_account, input#account').not(".personal").parents('ul').find('i').removeClass('si-plus').addClass('si-minus');
                $('li#sub_account').not(".personal").css("display", "block");
            }else
            {
                $('input#sub_account, input#account').not(".personal").prop('checked',false);
                $('input#sub_account, input#account').not(".personal").parents('ul').find('i').addClass('si-plus').removeClass('si-minus');
                $('li#sub_account').not(".personal").css("display", "none");
            }

        })

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

    $('input#sub_account').on('change', function(){

            $('input').not('.personal').prop('checked', false);
            $(this).prop('checked', true);

    })
</script>

@endsection
