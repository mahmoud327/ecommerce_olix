@extends('layouts.master')
@section('title')
orgniazation 
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
                <h4 class="content-title mb-0 my-auto">{{ trans('lang.orgniazation') }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ 
                    {{ trans('lang.orgniazation') }}</span>
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

                    @can('create_organization')

                    <a  href="#"   data-toggle="modal" data-target="#add"><i
                                class="btn btn-primary btn-sm" > {{trans('lang.add_orgniazation') }}</i>&nbsp;&nbsp;
                    </a>  
                    
                     @can('delete_organization')
                        <a href="{{route('organizations.trash_organizations')}}" class="btn btn-sm btn-danger">
                            Trash
                        </a>
                    @endcan
                   @endcan

               
  
                 <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                     aria-hidden="true">
                      <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">{{ trans('lang.orgniazation') }}</h5>
                                 
                                </div>
                                <form action="{{route('organizations.store')}}" method="post" enctype="multipart/form-data"> 
                                    {{ csrf_field() }}
                                    <div class="modal-body">
    
                                        <input type="hidden" name="organization_type_id" value="{{$organization_type_id}}" > 

                                            <div class="form-group">
                                                <label for="exampleFormControlTextarea1"> Add orgniazation</label>
                                            </div>
                                            
                                             <div class="form-group" id="lnWrapper">
                                                <label> English name: <span class="tx-danger">*</span></label>
                                                <textarea class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper"
                                                name="name_en" placeholder="English name"   >{{ old('name_en') }}</textarea>
                                            </div>

                                            <div class="form-group"id="lnWrapper">
                                                <label>Arabic name: <span class="tx-danger">*</span></label>
                                                <textarea class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper"
                                                name="name_ar" placeholder="Arabic name"   >{{ old('name_ar') }}</textarea>
                                            </div>


                                            <div class="form-group">
                                                <label for="exampleFormControlTextarea1">link</label>
                                                <input type="text" class="form-control" id="name" name="link" placeholder="arabic name" > 
                                            </div>
                                            

                                        <div id="other_data" class="tab-pane ">
                                            <div class="div_inputs ">
                                              
                                               <div>
                                                    <label>phone</label>
                                                    
                                                    <input class="form-control form-control-sm mg-b-20"
                                                    data-parsley-class-handler="#lnWrapper" name="phones[]" type="text" placeholder="phone"      
                                                    value="">
                
                                                    <div class="clearfix"></div>
                                                    <br>
                                                    <a href="#" class="remove_input btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                                    <br>
                                                
                                                </div>   
                                                    
                                             </div>
                                                
                                            <br>
                                    
                                            <a href="#" class="add_input btn btn-info btn-sm"><i class="fa fa-plus"></i></a>
                    
                                        </div>
                                        
                                    
                                        
                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">background_cover</label>
                                            <input class="form-control form-control-sm mg-b-20"
                                            name="background_cover" type="file" >                
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">{{trans('lang.orgniazation_image') }}</label>
                                            <input class="form-control form-control-sm mg-b-20"
                                            name="image" type="file">                
                                        </div>

                                        <div class="form-group">

                                            <label for="exampleFormControlTextarea1">description</label>
                                            <textarea type="text" class="form-control" id="name" name="description" placeholder="description"> </textarea>
                                        </div>
                                        

                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">{{trans('lang.save') }}</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('lang.close') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
 
                <br>
                <br>
                
                @can('delete_organizations')

                    <a  href="#"
                        data-toggle="modal" data-target="#delete_all"><i
                            class="btn btn-danger  btn-sm" id="btn_delete_all"  >{{ trans('lang.delete_all') }}</i>&nbsp;&nbsp;
                        </a>         
        
                    </div>

                    <div class="modal fade" id="delete_all" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">{{trans('lang.delete') }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <form action="{{route('organizations.delete_all')}}" method="post">
                                        {{ method_field('delete') }}
                                        {{ csrf_field() }}
                                </div>
                                <div class="modal-body">
                                    <input class="text" type="hidden" id="delete_all_id" name="delete_all_id" value=''>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('lang.close')}}</button>
                                    <button type="submit" class="btn btn-danger">{{trans('lang.save') }}</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endcan
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
                                
                                @foreach ($organizations as $organization)
                                    @php
                                    $i++
                                    @endphp
                                    <tr>
                                        <td><input id="cat-box" type="checkbox" name="categories"  value="{{$organization->id}}" class="box1" ></td>
                                        <td>{{ $i }}</td>
                                        <td>{{ $organization->name }} </td>
                                    
                                         <td> 
                                          @if($organization->media()->exists())
                                              
                                            <img src="{{ env('AWS_S3_URL') .'/'.$organization->media()->first()->url}}" height="50px" width="50p" >
                                        
                                         </td>

                                        @endif
                                        
                                        <td>
                                            <img src="{{ env('AWS_S3_URL') .'/'.$organization->background_cover}}" height="50px" width="50p" >
                                        </td>

                                        <td>

                                            @can('update_organization')
                                            <a  href="#" data-product_id="{{ $organization->id }}"
                                                    data-toggle="modal" data-target="#edit{{$organization->id}}"><i class="fas fa-edit"></i>
                                                    &nbsp;&nbsp;
                                            </a> 
                                            @endcan
                                            @include('web.admin.organizations.modal_edit',['organization' => $organization])

                                            @can('delete_organization')
                                                
                                                <a  href="#" data-product_id="{{ $organization->id }}" data-toggle="modal" data-target="#delete_prodcut{{ $organization->id }}" class="btn btn-danger btn-sm">
                                                    hide
                                                </a> 
                                            @endcan

                                            <!--<a  href="{{route('post_organization',$organization->id)}}" >-->
                                            <!--        <i class="btn btn-info  btn-sm fas"  >posts</i>&nbsp;&nbsp;-->
                                            <!--</a> -->
                                     

                                            @include('web.admin.organizations.modal_delete',['organization' => $organization])
                                            
                                        
                                
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