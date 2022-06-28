@extends('layouts.master')
@section('title')
orgniazation_mobile
@stop
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('lang.orgniazation') }} mobile</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ 
                    {{ trans('lang.orgniazation') }} mobile </span>
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


                 <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                     aria-hidden="true">
                      <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">{{ trans('lang.orgniazation') }}</h5>
                                 
                                </div>
                              
                            </div>
                        </div>
                    </div>
 
                <br>
                <br>
                
         
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'style="text-align: center">
                            <thead>
                                <tr>
                                    <th><input name="select_all" id="delete_all" type="checkbox" onclick="CheckAll('box1', this)" /></th>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0"> {{trans('lang.orgniazation_name')}}</th>
                                    <th class="border-bottom-0"> {{ trans('lang.orgniazation_image')}}</th>
                                    <th class="border-bottom-0">background_cover</th>
                                    <th class="border-bottom-0">{{ trans('lang.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i = 0;
                                @endphp
                                
                                @foreach ($organizations_mobile as $organization_mobile)
                                    @php
                                    $i++
                                    @endphp
                                    <tr>
                                        <td><input id="cat-box" type="checkbox" name="categories"  value="{{$organization_mobile->id}}" class="box1" ></td>
                                        <td>{{ $i }}</td>
                                        <td>{{ $organization_mobile->name }} </td>
                                    
                                         <td> 
                                          @if($organization_mobile->media()->exists())
                                              
                                            <img src="{{asset($organization_mobile->media()->first()->url)}}" height="50px" width="50p" >
                                        
                                         </td>

                                        @endif
                                        
                                        <td>
                                            <img src="{{asset($organization_mobile->background_cover)}}" height="50px" width="50p" >
                                        </td>

                                          <td>

                                     
            
                                        </td>
                                    </tr>
                                @endforeach

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
    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>

    <script type="text/javascript">

        var x=2;
          $(document).on('click','.add_input',function(e){
                  e.preventDefault();
                  $('.div_inputs').append('<div>'+
                
                          '<lable>phone</lable>'+
                          '<br>'+
    
                          '<input type="phone" name="phones[]" class="form-control" placeholder="phone" /> '+
                      '<div class="clearfix"></div>'+
                      '<br>'+
                      '<a href="#" class="remove_input btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>'+
                      '<br>'+
                  '</div>');
                  x++;
          });
          $(document).on('click','.remove_input',function(){
              $(this).parent('div').remove();
              x--;
              return false;
          });
  </script>

    <script type="text/javascript">

        var x=2;
          $(document).on('click','.add_input_edit',function(e){
                  e.preventDefault();
                  $('.div_inputs_edit').append('<div>'+
                
                          '<lable>phone</lable>'+
                          '<br>'+
    
                          '<input type="phone" name="phones[]" class="form-control" placeholder="phone" /> '+
                      '<div class="clearfix"></div>'+
                      '<br>'+
                      '<a href="#" class="remove_input_edit btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>'+
                      '<br>'+
                  '</div>');
                  x++;
          });
          $(document).on('click','.remove_input_edit',function(){
              $(this).parent('div').remove();
              x--;
              return false;
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