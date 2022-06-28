
@extends('layouts.master')
@section('css')
<!---Internal Fileupload css-->
<link href="{{URL::asset('assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css"/>
<!---Internal Fancy uploader css-->
<link href="{{URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css')}}" rel="stylesheet" />
<!--Internal Sumoselect css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css')}}">
<!--Internal  TelephoneInput css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css')}}">


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@if(App::getLocale() == 'en')
<!--Internal  treeview -->
<link href="{{URL::asset('assets/plugins/treeview/treeview.css')}}" rel="stylesheet" type="text/css" />
@else
<!--Internal  treeview -->
<link href="{{URL::asset('assets/plugins/treeview/treeview-rtl.css')}}" rel="stylesheet" type="text/css" />
@endif



@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('lang.orgniazation') }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ 
                    {{ trans('lang.orgniazation') }}</span>
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
        <!--div-->
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">


                    <a  href="{{route('organization_services.create')}}" ><i
                                class="btn btn-primary btn-sm" > add organization_service</i>&nbsp;&nbsp;
                    </a>    


                    <a  href="#"
                        data-toggle="modal" data-target="#delete_all"><i
                        class="btn btn-danger  btn-sm" id="btn_delete_all"  >delete all</i>&nbsp;&nbsp;
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
                                <form action="{{route('organization_services.delete_all') }}" method="post">
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
    

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'style="text-align: center">
                            <thead>

                                <tr>
                                    <th><input name="select_all" id="delete_all" type="checkbox" onclick="CheckAll('box1', this)" /></th>

                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0"> name</th>
                                    <th class="border-bottom-0"> {{ trans('lang.orgniazation_image')}}</th>
                                    <th class="border-bottom-0">{{ trans('lang.action') }}</th>
                                </tr>
                            </thead>
                            <tbody id="tablecontents">
                                @php
                                $i = 0;
                                @endphp
                                
                                @foreach ($organization_services as $organization_service)
                                    @php
                                    $i++
                                    @endphp
                                    <tr  class="tr" data-id="{{ $organization_service->id }}">
                                        <td><input id="cat-box" type="checkbox" name="admins"  value="{{$organization_service->id}}" class="box1" ></td>

                                        <td>{{ $i }}</td>
                                        <td>{{ $organization_service->name }} </td>                                      
                                        
                                   
                                         <td><img style="width: 80px;height:60px" src="{{asset($organization_service->image)}}" alt="product-image">
                                     

                                        <td>

                                            <a  href="{{route('organization_services.edit',$organization_service->id)}}"
                                                  ><i class="fas fa-edit"></i>
                                                    &nbsp;&nbsp;
                                            </a> 

                                            <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                               data-toggle="modal" href="#modaldemo9{{ $organization_service->id }}" title="delete"><i
                                                class="las la-trash"></i>
                                            </a>
                                        
                                    
                                            @include('web.admin.organization_services.modal_delete',['organization_service' => $organization_service])
                                            
                                        
                                
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
        $('table .tr').each(function(){

                var id = $(this).data('id');
                order.push(id);

            });
        
        $.ajax({
          type: "post", 
          dataType: "json", 
          url: "{{ url('admin/organization_services/sortabledatatable') }}",
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

    $(document).ready(function() {
            $('.products').select2();

            $('.products').select2({
            closeOnSelect: false

            });

   
        
        });

    <script>
@endpush