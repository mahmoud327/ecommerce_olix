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

        svg ,.dataTables_length
          {
             display:none;
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

                 @can('delete_all_user')
                    
                    <a  href="#"
                        data-toggle="modal" data-target="#delete_all"><i
                        class="btn btn-danger  btn-sm" id="btn_delete_all"  >{{ trans('lang.delete_all') }}</i>&nbsp;&nbsp;
                    </a> 

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
                <div  style="margin-left:70%" > 
                    <form class="form-inline" action="{{ route('user.search') }}" method="GET">
                        
                        <div class="form-group mx-sm-3">
                            <button type="submit" class="btn btn-primary">بحث</button>
                            
                            <input type="text" class="form-control ml-5" name="query" id="query" 
                                placeholder="" value="{{ request()->input('query') }}" required>
                        </div>
                    </form>
               </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'style="text-align: center">
                            <thead>
                                <tr>

                                    <th><input name="select_all" id="delete_all" type="checkbox" onclick="CheckAll('box1', this)" /></th>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">{{ trans('lang.user_name') }} </th>
                                    <th class="border-bottom-0">{{ trans('lang.user_email') }} </th>
                                    <th class="border-bottom-0">{{ trans('lang.user_mobile') }} </th>
                                    <th class="border-bottom-0">points </th>
                                    <th class="border-bottom-0">countOfProducts </th>
                                    {{-- <th class="border-bottom-0">{{ trans('lang.user_privilage') }} </th>
                                    <th class="border-bottom-0">permission</th> --}}

                                    <th class="border-bottom-0">{{ trans('lang.action') }}</th>
                                    <th class="border-bottom-0">{{ trans('lang.created_at') }}</th>
                                
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i = 0;
                                @endphp
                                @foreach ($users as $user)
                                    @php
                                    $i++
                                    @endphp
                                    <tr>
                                        <td><input id="cat-box" type="checkbox" name="categories"  value="{{$user->id}}" class="box1" ></td>
                                        <td>{{ $loop->iteration + $skipped }}</td>
                                        <td>{{ $user->name }} </td>
                                        <td>{{ $user->email }} </td>
                                        <td>{{$user->mobile }} </td>
                                        <td>{{ $user->points }} </td>
                                        <td>{{ optional($user->product)->count() }} </td>
                                        <td>

                               

                                            @can('delete_user')
                                                
                                                <a  href="#" data-user_id="{{$user->id}}"
                                                    data-toggle="modal" data-target="#modaldemo9{{$user->id}}"><i
                                                        class="btn btn-danger  btn-sm fas fa-trash-alt"  ></i>
                                                </a>
                                            @endcan

                                            @can('user_upgrade')
                                                
                                                
                                            <a href="{{url(route('users.products_of_user', $user->id))}}" @if( $user->products()->count() ) class="btn btn-primary btn-sm"  @else class="btn btn-danger btn-sm" @endif > P </a>
                                            @endcan     

                                            @include('web.admin.users.delete_modal',['user' => $user])

                                            
                                        
                                        </td>
                                        <td>{{ $user->created_at }} </td>


                                    </tr>
                                @endforeach
                                <div style="margin-bottom:40px">
                             
                                    {{ $users->links() }}
                              </div>

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