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
    <link href="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet">
    <!--- Internal Sweet-Alert css-->
    <link href="{{URL::asset('assets/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('lang.products') }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ 
                    {{ trans('lang.trash') }}</span>
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

                    <a class="btn btn-primary btn-sm" href="{{route('products.productofdashboardfinsih')}}">{{ trans('lang.back') }}</a>


                    <a  href="#"
                        data-toggle="modal" data-target="#force_delete_all"><i
                            class="btn btn-danger  btn-sm" id="btn_force_delete_all"  >{{ trans('lang.delete_all') }}</i>&nbsp;&nbsp;
                    </a> 

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
                                    <form action="{{route('product.force_delete_all') }}" method="post">
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
                                    <form action="{{route('product.restore_all') }}" method="post">
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
                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'style="text-align: center">
                            <thead>
                                <tr>
                                    <th><input name="select_all" id="delete_all" type="checkbox" onclick="CheckAll('box1', this)" /></th>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">{{ trans('lang.product_name') }} </th>
                                    <th class="border-bottom-0">{{ trans('lang.last_categories') }} </th>

                                    <th class="border-bottom-0">{{ trans('lang.price') }} </th>
                                    <th class="border-bottom-0">{{ trans('lang.quantity') }}</th>
                                    <th class="border-bottom-0">{{ trans('lang.orgniazation') }}</th>
                                    <th class="border-bottom-0">{{ trans('lang.action') }}</th>
                                    <th class="border-bottom-0">{{ trans('lang.deleted_at') }}</th>

                                </tr>
                            </thead>
                            <tbody>
                                
                                @php
                                $i = 0;
                                @endphp

                                @foreach ($products as $product)
                                    @php
                                    $i++
                                    @endphp
                                    <tr class='tr'>

                                        <td><input id="cat-box" type="checkbox" name="categories"  value="{{$product->id}}" class="box1" ></td>
                                        <td>{{ $i }}</td>
                                        <td>{{ $product->name }} </td>
                                        <td>{{optional($product->category)->name}}</td>   
                                        
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->quantity}}</td>  
                     
                                        <td>
                                            @if($product->organization()->exists())
                                                <a  href="#" data-product_id="{{ $product->organization_id }}" class="btn btn-primary btn-sm"
                                                    data-toggle="modal" data-target="#images{{$product->organization_id}}"><i
                                                    > {{ trans('lang.details') }}</i>
                                                </a>
                                                @include('web.admin.products_category.modal_organization',['product' => $product])
                                            @endif

                                        </td>
 
                                        <td>
                                           
                                            <a  href="#" data-product_id="{{ $product->id }}" class="btn btn-primary btn-sm"
                                                data-toggle="modal" data-target="#images{{$product->id}}"><i> {{ trans('lang.image') }}</i>
                                            </a>

                                            <a  href="{{ route('product.restore_product', $product->id) }}" class="btn btn-success btn-sm">restore</a>       

                                            <a  href="#" data-product_id="{{ $product->id }}"
                                                data-toggle="modal" data-target="#force_delete_prodcut{{$product->id}}"><i
                                                    class="btn btn-danger  btn-sm fas fa-trash-alt"  ></i>&nbsp;&nbsp;
                                            </a>       
                                    
                                            {{-- @include('web.admin.products_category.modal_delete',['product' => $product]) --}}
                                            @include('web.admin.products_category.modal_force_delete',['product' => $product])

                                                        
                                                </a>                                                 
                                           <div class="modal fade" id="images{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">{{ trans('lang.image') }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                            
                                                        </div>
                                                        <div class="modal-body">

                                                            @inject('image', 'App\Models\Media')
                                              
                                                         
                                                            <div class="form-group mb-2">
                                              
                                                            @foreach ($image->where('mediaable_id',$product->id)->where('mediaable_type','App\Models\Product')->get() as $images)
                                                                <div style="display:inline-block;"
                                                                    class="text-center"><img src="{{env('AWS_S3_URL').'/'.$images->path}}" height="50px" width="50p">
                                                                </div>
                                                             @endforeach
                                              
                                                           
                                                            </div>
                                                         
                                                        </div>
                                                
                                                     
                                                    </div>
                                                </div>
                                            </div>

                                


                                            
           
                                        </td>

                                        <td>{{ $product->deleted_at }} </td>


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

<script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>

   <!-- jQuery UI -->
    <script type="text/javascript" src="//code.jquery.com/ui/1.12.1/jquery-ui.js" ></script>
 
    <!-- Datatables Js-->
<script>
    $(document).ready(function() {
  $('#search').on('change', function() {
     document.forms[myFormName].submit();
  });
});
</script> 

 <script>
    $(function(){
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



@endsection