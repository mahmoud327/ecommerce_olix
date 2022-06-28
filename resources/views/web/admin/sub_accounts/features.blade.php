@extends('layouts.master')

@section('title')
{{ trans('lang.page_title_of_sub_account') }}
@stop

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


@endsection
@section('page-header')
            <!-- breadcrumb -->
            <div class="breadcrumb-header justify-content-between">
                <div class="my-auto">
                    <div class="d-flex">
                        <h4 class="content-title mb-0 my-auto">Dashboard</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{$sub_account->name}} / Change Feature </span>
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
        <div class="row row-sm">
            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                <div class="card  box-shadow-0">
                    <div class="card-header">
                        <h4 class="card-title mb-1">Change Feature</h4>
                    </div> 
                    <div class="card-body pt-0">
                        <form class="form-horizontal" method="post" action=" {{route('change_features', $sub_account->id)}}"> 
                            @csrf

                            <div class="row">

                                <div class="col-lg-4">
                                                
                                            <input type="checkbox" id="check_all_records" class="m-2"><span>All features</span>
                                            <ul>
                                                @foreach ($features as $feature)
                                        
                                                    <li id="features" >
                                                        
                                                        <input id="feature"  @if( in_array( $sub_account->id, json_decode( $feature->subAccounts->pluck('id')  ) ) ) checked   @endif   type="checkbox" style="margin:3px"  name="features[]" value="{{$feature->id}}" class="m-2">{{$feature->name}}
                                                        
                                                    </li>

                                                @endforeach
                                            </ul>
                                            
                                </div>
                                
                                
                                

                                <div class="col-lg-12 mt-5 text-center">
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

        var all_childs = $('input#feature').length;
        var checked_childs = $('input#feature:checked').length;

        if( all_childs === checked_childs)
        {
            $('input#check_all_records').prop('checked',true);
        }else
        {
            $('input#check_all_records').prop('checked',false);

        }
        
        $('input#check_all_records').on('change', function(){

            if($(this).is(':checked'))
            {
                $('input#feature').prop('checked',true);



            }else
            {
                $('input#feature').prop('checked',false);


            }
            
        })

        $('input#feature').on('change', function(){


            var all_childs = $('input#feature').length;
            var checked_childs = $('input#feature:checked').length;

            if( all_childs === checked_childs)
            {
                $('input#check_all_records').prop('checked',true);
            }else
            {
                $('input#check_all_records').prop('checked',false);

            }


        })
    })
    
</script>




@endsection