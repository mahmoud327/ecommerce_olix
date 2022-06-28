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

        

@section('title')
Sub Filter - Trash
@stop

@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Dashboard</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                Filter Trash Module</span>
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
                    
                {{-- <a  href="#"
                        data-toggle="modal" data-target="#force_delete_all"><i
                            class="btn btn-danger  btn-sm" id="btn_force_delete_all"  >{{ trans('lang.delete_all') }}</i>&nbsp;&nbsp;
                </a>  --}}
  

                <a  href="#"
                            data-toggle="modal" data-target="#restore_all"><i
                                class="btn btn-success  btn-sm" id="btn_restore_all"  >{{ trans('lang.restore_all') }}</i>&nbsp;&nbsp;
                </a>

            </div>
            
            
            <div class="modal fade" id="force_delete_all" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ trans('lang.delete') }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <form action="{{route('sub_filters.force_delete_all') }}" method="post">
                                    {{ csrf_field() }}
                            </div>
                            <div class="modal-body">
                                <input class="text" type="hidden" id="force_delete_all_id" name="force_delete_all_id" value=''>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('lang.close') }}</button>
                                <button type="submit" class="btn btn-danger">{{ trans('lang.save') }}</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="modal fade" id="restore_all" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ trans('lang.restore_all')}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <form action="{{route('sub_filters.restore_all') }}" method="post">
                                    {{ csrf_field() }}
                            </div>
                            <div class="modal-body">
                                <input class="text" type="hidden" id="restore_all" name="restores_ids" value=''>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('lang.close') }}</button>
                                <button type="submit" class="btn btn-success">{{ trans('lang.restore_all') }}</button>
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
                                <th><input name="select_all" id="delete_all" type="checkbox" onclick="CheckAll('box1', this)" /></th>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">{{ trans('lang.filter_name') }}</th>
                                <th class="border-bottom-0">image</th>
                                <th class="border-bottom-0">{{ trans('lang.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sub_filters as $sub_filter )

                                <tr>
                                    <td><input id="cat-box" type="checkbox" name="organizations"  value="{{$sub_filter->id}}" class="box1" ></td>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $sub_filter->name }}</td>
                                    <td><img style="width: 80px;height:60px" src="{{asset('uploads/Filters')}}/{{$sub_filter->image}}" alt="categories-image"></td>

                                    <td>

                                        <a  href="{{ route('sub_filters.restore_sub_filter', $sub_filter->id) }}" class="btn btn-success btn-sm">restore</a>

                                        {{-- <a  href="#" data-sub_filter_id="{{ $sub_filter->id }}"
                                            data-toggle="modal" data-target="#force_delete_sub_filter{{$sub_filter->id}}"><i
                                                class="btn btn-danger  btn-sm fas fa-trash-alt"  ></i>&nbsp;&nbsp;
                                        </a>  --}}

                                    </td>
                                </tr>

                                @include('web.admin.filters.sub_filters.modal_force_delete',['sub_filter' => $sub_filter])
                            @endforeach
                        </tbody>
                    </table>
                </div>
              
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

@if(App::getLocale() == 'en')
<!--Internal  treeview -->
<link href="{{URL::asset('assets/plugins/treeview/treeview.css')}}" rel="stylesheet" type="text/css" />
@else
<!--Internal  treeview -->
<link href="{{URL::asset('assets/plugins/treeview/treeview-rtl.css')}}" rel="stylesheet" type="text/css" />
@endif

<script>

///////////////for add modal
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
    })

</script>

<script>

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
            var checked_childs = $(this).parent('li').parent('ul').find('input#sub_account_edit):checked').length;
            if( all_childs === checked_childs)
            {
                $(this).parent('li').parent('ul').siblings('input#account_edit').prop('checked',true);
            }else
            {
                $(this).parent('li').parent('ul').siblings('input#account_edit').prop('checked',false);
            }
          })
        })
    
    
    
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
    $(function(){


        $("#btn_force_delete_all").click(function() {
            var selected = new Array();
            $("#example1 input[type=checkbox]:checked").each(function() {
                selected.push(this.value);
                
            });
            if (selected.length > 0) {
                $('#force_delete_all').modal('show')
                $('input[id="force_delete_all_id"]').val(selected);
            }
        });
    
        $("#btn_restore_all").click(function() {
            var selected = new Array();
            $("#example1 input[type=checkbox]:checked").each(function() {
                selected.push(this.value);
                
            });
            if (selected.length > 0) {
                $('#restore_all').modal('show')
                $('input[id="restore_all"]').val(selected);
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