@extends('layouts.master')
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

<style>
    .SumoSelect>.CaptionCont {
        width: 60%;
    
        }
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
    
    .SumoSelect>.optWrapper.multiple>.options li.opt span i, .SumoSelect .select-all>span i
    {
        position: absolute;
        margin: auto;
        top: 0;
        bottom: 0;
        width: 14px;
        height: 14px;
        border: 1px solid #e1e6f1;
        border-radius: 2px;
        background-color: #fff;
    }
    
    .SumoSelect>.optWrapper>.options li.opt label, .SumoSelect>.CaptionCont, .SumoSelect .select-all>label {padding-left: 40px;}
    
    
    .SumoSelect>.CaptionCont>span {color: #000}
    
    .SumoSelect.open>.optWrapper {
        width: 550px;
    }
    
</style>


@endsection
@section('page-header')
            <!-- breadcrumb -->
            <div class="breadcrumb-header justify-content-between">
                <div class="my-auto">
                    <div class="d-flex">
                        <h4 class="content-title mb-0 my-auto">Dashboard</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Create Recurring Filter</span>
                    </div>
                </div>
            </div>
            <!-- breadcrumb -->
@endsection
@section('content')

@inject('services','App\Models\Service')



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

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

             

				<!-- row -->
				<div class="row row-sm">
                    
					<div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
						<div class="card  box-shadow-0">
							<div class="card-header">
                                <div class="pull-right">
                                    <a class="btn btn-primary btn-sm" href="{{route('organization_services.index')}}">{{ trans('lang.back') }}</a>
                                </div>
                                
							</div> 
							<div class="card-body pt-0">
                            
                            
                                <form action="{{route('organization_services.store')}}" method="post" enctype="multipart/form-data"> 
                                    @csrf
                                    <div class="row">
                                        
                                        <div class="col-lg-4">
                                            
                                            <div class="form-group" id="lnWrapper">
                                                <label> English name: <span class="tx-danger">*</span></label>
                                                <textarea class="form-control" data-parsley-class-handler="#lnWrapper"
                                                name="name_en" placeholder="English name"   >{{ old('name_en') }}</textarea>
                                            </div>
                
                                            <div class="form-group"id="lnWrapper">
                                                <label>Arabic name: <span class="tx-danger">*</span></label>
                                                <textarea class="form-control" data-parsley-class-handler="#lnWrapper"
                                                name="name_ar" placeholder="Arabic name"   >{{ old('name_ar') }}</textarea>
                                            </div>


                                                
                
                                            <div  class="form-group"  id="other_data" class="tab-pane ">
                                                <div class="div_price ">
                                                  
                                                   <div>
                                                               
                                                        <div class="form-group" id="lnWrapper">
                                                            <label>select service: <span class="tx-danger">*</span></label>
                                                            <div class=""  id="services">
                
                                                          
                                                                <select name="services_id[]" class="form-control form-select" style="width:100%">

                                                                    <option value=""> select service </option>
                                                                    @foreach ($services->get() as $service)
                    
                                                                            <option  onlyslave="True"  value="{{$service->id}}">
                                                                                {{$service->name}}
                                                                            </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                            
                                                        <label>price</label>
                                                        
                                                        <input class="form-control form-control"
                                                        data-parsley-class-handler="#lnWrapper" name="price[]" type="number" placeholder="price"     
                                                        value="">
                    
                                                        <div class="clearfix"></div>
                                                        <br>
                                                        <a href="#" class="remove_price btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                                        <br>
                                                    
                                                    </div>   
                                                        
                                                 </div>
                                                    
                                                <br>
                                        
                                                <a href="#" class="add_price btn btn-info btn-sm"><i class="fa fa-plus"></i></a>
                        
                                            </div>
                
                                     
                                         
                                                
                
                                            <div  class="form-group"  id="other_data" class="tab-pane ">
                                                <div class="div_inputs ">
                                                  
                                                   <div>
                                                        <label>phone</label>
                                                        
                                                        <input class="form-control form-control"
                                                        data-parsley-class-handler="#lnWrapper" name="phones[]" required type="number" placeholder="phone"      
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
                                                
                                                <label for="exampleFormControlTextarea1">description</label>
                                                <textarea type="text" class="form-control" id="name" name="description" placeholder="description"> </textarea>
                                            </div>



                                            <div  class="form-group"  id="other_data" class="tab-pane ">
                                                <div class="div_link ">
                                                  
                                                   <div>
                                                        <label>link</label>
                                                        
                                                        <input class="form-control form-control"
                                                        data-parsley-class-handler="#lnWrapper" name="links[]" required type="text" placeholder="link"      
                                                        value="">
                    
                                                        <div class="clearfix"></div>
                                                        <br>
                                                        <a href="#" class="remove_link btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                                        <br>
                                                    
                                                    </div>   
                                                        
                                                 </div>
                                                    
                                                <br>
                                        
                                                <a href="#" class="add_link btn btn-info btn-sm"><i class="fa fa-plus"></i></a>
                        
                                            </div>
                                            
                                            

                                            <div class="form-group">
                                                @inject('governorates','App\Models\Governorate')
                                                <select name="governorate_id" id="governorates" class="form-control form-select" style="width:100%" required>
                                                    <option> select governorate</option>
                                                    @foreach ($governorates->get() as $governorate)

                                                        <option  onlyslave="True"  value="{{$governorate->id}}">
                                                            {{$governorate->name}}
                                                        </option>
                                                    @endforeach


                                                </select>

                                              </div>
                              
                                              <div class="form-group">

                                                @inject('cities','App\Models\City')

                                                <select name="city_id" id="cities" class="form-control form-select" style="width:100%" required>
                                                    <option valaue="null"> select cities</option>
                                    

                                                </select>

                              
                                              </div>

                                             <div class="form-group">
                                                
                                                <label for="exampleFormControlTextarea1">google map link</label>
                                                <input type="text" class="form-control" id="name" name="google_map_link" placeholder="google_map_link"> 
                                            </div>
    
                                             
                                        </div>
                                        
                                        
                                        <div class="col-lg-8">

                                            <div class="row mg-t-10">

                                                <div class="col-lg-4">

                                                    <label class="rdiobox"><input  name="type_of_categories" value="1" type="radio" checked> <span>All Categories</span></label>
                                                    <br>
                                                    <div id="all_categories">
                                                        <label>Category :</label>
                                                        
                                                        <ul id="tree2" >
                                                            @foreach ($parent_categories as $category)
                                                                <li> 
        
                                                                    @if ( $category->view->id == $last_level_id )
                                                                    <input class="last_level_category" type="checkbox" name="last_categories[]" value="{{$category->id}}" class="m-2">
        
                                                                    @else
                                                                    <input data-id="{{ $category->id}}"  class="category" type="checkbox" class="m-2">
        
                                                                    @endif
        
                                                                    <a href="#" data-id="{{ $category->id}}" @if ( $category->view->id == $last_level_id  ) style="background-color:#229dff;color:#FFF;padding: 0px 10px;"@endif>{{$category->name}}</a>
        

                                                                     @if ( $category->childs()->count() )
                                                                        @include('web.admin.recurring_filters.tree_category', ['categories'   => $category->childs() , 'last_level_id' => $last_level_id ])
                                                                    @endif 
                                                                    
                                                                </li>
                                                            @endforeach
                                                        </ul>

                                                      </div>


                                                </div>

                                                <div class="col-lg-4 mg-t-20 mg-lg-t-0">

                                                    <label class="rdiobox"><input name="type_of_categories" value="2" type="radio"> <span>Recurring Categories</span></label>                       
                                                    <br>

                                                    <div id="recurring_categories" class="d-none">
                                                        <ul id="tree3" >
                                                            @foreach ($recurring_categories as $recurring_category)
                                                                <li> 
        
                                                                    @if ($recurring_category->view->name == 'last_level'  )
                                                                    <input class="last_level_recurring_category" type="checkbox" name="last_recurring_categories[]" value="{{$recurring_category->id}}" class="m-2">
        
                                                                    @else
                                                                    <input class="recurring_category" type="checkbox" class="m-2">
        
                                                                    @endif
        
                                                                    <a href="#" @if ( $recurring_category->view->name == 'last_level' ) style="background-color:#229dff;color:#FFF;padding: 0px 10px;"@endif>{{$recurring_category->name}}</a>
        
                                                                    @if ( $recurring_category->recurringChilds()->count() )
                                                                        @include('web.admin.recurring_filters.tree_recurring_category', ['recurring_categories'   => $recurring_category->recurringChilds()])
                                                                    @endif
                                                                    
                                                                </li>
                                                            @endforeach
        
                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>


                                             
                    
                                            <div class="form-group col-md-4">

                                                <label for="exampleFormControlTextarea1">chose image</label>
                                                <input class="form-control form-control"
                                                name="image" type="file"> 

                                            </div>
                                            

                                        <div class="col-lg-12 mt-4 text-center">
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

    $(document).ready(function() {
            $('#governorate').select2();

            $('#governorate').select2({
            closeOnSelect: false

            });
        
        });



    $(function (){


        
        $('input.account, input.sub_account,.check_all_accounts').prop('checked',true);
        $('li.sub_account').css("display", "block");

        
        $('input.account').on('change', function(){

            if($(this).is(':checked'))
            {
                $(this).siblings('i').removeClass('si-plus').addClass('si-minus');
                $(this).siblings('ul').find('li').css("display", "block");
                $(this).siblings('ul').find('input.sub_account').prop('checked',true);


            }else
            {
                // $(this).siblings('i').addClass('si-plus').removeClass('si-minus');
                // $(this).siblings('ul').find('li').css("display", "none");
                $(this).siblings('ul').find('input.sub_account').prop('checked',false);


            }
            
        })
        
        $('input.sub_account').on('change', function(){


            var all_childs = $(this).parent('li').parent('ul').find('input.sub_account').length;
            var checked_childs = $(this).parent('li').parent('ul').find('input.sub_account:checked').length;

            if( all_childs === checked_childs)
            {
                $(this).parent('li').parent('ul').siblings('input.account').prop('checked',true);
            }else
            {
                $(this).parent('li').parent('ul').siblings('input.account').prop('checked',false);

            }


        })



    })
    
</script>


{{-- categories checker --}}
<script>

    $(function (){
        
        $('input.category').on('change', function(){

            if($(this).is(':checked'))
            {
                $(this).siblings('i').removeClass('si-folder').addClass('si-folder-alt');
                $(this).siblings('ul').find('li').css("display", "block");
                $(this).siblings('ul').find('i').removeClass('si-folder').addClass('si-folder-alt');
                $(this).siblings('ul').find('input.category, input.last_level_category').prop('checked',true);


            }else
            {
                $(this).siblings('i').removeClass('si-folder-alt').addClass('si-folder');
                $(this).siblings('ul').find('li').css("display", "none");
                $(this).siblings('ul').find('input.category, input.last_level_category').prop('checked',false);


            }
            
        })


        // $('input.last_level_category').on('change', function(){


        //     var all_childs = $(this).parent('li').parent('ul').find('input.last_level_category').length;
        //     var checked_childs = $(this).parent('li').parent('ul').find('input.last_level_category:checked').length;

        //     if( all_childs === checked_childs)
        //     {
        //         $(this).parents('li').find('input.category').prop('checked',true);
        //     }else
        //     {
        //         $(this).parents('li').find('input.category').prop('checked',false);

        //     }


        // })
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

    $(function (){
        
        $('input[name="type_of_categories"]').on( 'change' ,function() 
        {
            var value = $(this).val();

            if( value == 1 )
            {
                
                $('#recurring_categories').addClass('d-none');
                $('#all_categories').removeClass('d-none');
                $('input[name="last_recurring_category"]').prop('checked',false);

            }else
            {
                $('#recurring_categories').removeClass('d-none');
                $('#all_categories').addClass('d-none');
                $('input[name="last_categories[]"], input#category').prop('checked',false);


            }
            
        })
    })
    
</script>



<script>

    $(function (){
        
        $('input.recurring_category').on('change', function(){

            if($(this).is(':checked'))
            {
                $(this).siblings('i').removeClass('si-arrow-down-circle').addClass('si-arrow-right-circle');
                $(this).siblings('ul').find('li').css("display", "block");
                $(this).siblings('ul').find('i').removeClass('si-arrow-down-circle').addClass('si-arrow-right-circle');;
                $(this).siblings('ul').find('input.recurring_category, input.last_level_recurring_category').prop('checked',true);


            }else
            {
                $(this).siblings('i').removeClass('si-arrow-right-circle').addClass('si-arrow-down-circle');
                $(this).siblings('ul').find('li').css("display", "none");
                $(this).siblings('ul').find('input.recurring_category, input.last_level_recurring_category').prop('checked',false);


            }
            
        })


        $('input.last_level_recurring_category').on('change', function(){


            var all_childs = $(this).parent('li').parent('ul').find('input.last_level_recurring_category').length;
            var checked_childs = $(this).parent('li').parent('ul').find('input.last_level_recurring_category:checked').length;

            if( all_childs === checked_childs)
            {
                $(this).parents('li').find('input.recurring_category').prop('checked',true);
            }else
            {
                $(this).parents('li').find('input.recurring_category').prop('checked',false);

            }


        })
    })
    
</script>


@endsection

@push('script')
<script>

    var x=2;
      $(document).on('click','.add_input',function(e){
              e.preventDefault();
              $('.div_inputs').append('<div>'+
            
                      '<lable>phone</lable>'+
                      '<br>'+

                      '<input type="number" name="phones[]" class="form-control" placeholder="phone" /> '+
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

<script>

    var x=2;
      $(document).on('click','.add_link',function(e){
              e.preventDefault();
              $('.div_link').append('<div>'+
            
                      '<lable>link</lable>'+
                      '<br>'+

                      '<input type="text" name="links[]" class="form-control" placeholder="link" /> '+
                  '<div class="clearfix"></div>'+
                  '<br>'+
                  '<a href="#" class="remove_link btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>'+
                  '<br>'+
              '</div>');
              x++;
      });
      $(document).on('click','.remove_link',function(){
          $(this).parent('div').remove();
          x--;
          return false;
      });
</script>

<script>

    var x=2;
      $(document).on('click','.add_price',function(e){
              e.preventDefault();
              $('.div_price').append('<div>'+

                 '<div class="form-group" id="lnWrapper">'+
                        '<label>select service: </label>'+

                        '<div class=""  id="services">'+

                        '<select name="services_id[]" class="form-control form-select" style="width:100%" >'+

                          '<option  value=""> select service</option>'+

                            '@foreach ($services->get() as $service)'+

                                    '<option  onlyslave="True"  value="{{$service->id}}">'+
                                        '{{$service->name}}'+
                                    '</option>'+
                            '@endforeach'+
                        '</select>'+
                        '</div>'+
                    '</div>'+
                      '<br>'+
            
                      '<lable>price</lable>'+
                      '<br>'+

                      '<input type="number" name="price[]" class="form-control" placeholder="price" required /> '+
                  '<div class="clearfix"></div>'+
                  '<br>'+
                  '<a href="#" class="remove_price btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>'+
                  '<br>'+
              '</div>');
              x++;
      });
      $(document).on('click','.remove_price',function(){
          $(this).parent('div').remove();
          x--;
          return false;
      });
</script>



<script>
    $(document).ready(function() {
        $('.services').select2();

        $('.services').select2({
         closeOnSelect: false

        });

    });

</script>


<script>
    
    //if governorates changed
    $("#governorates").change(function (e){
      e.preventDefault();
      // get gov
      var governorate_id = $("#governorates").val();
      //console.log(g);
      if(governorate_id)
      {
        $.ajax({
          url      : '{{url('admin/organization_service_cities?governorate_id=')}}'+governorate_id,
          type     : 'get',
          success  : function (data) {
            if(data.status == 1)
            {
               
                $("#cities").empty();
                $("#cities").append('<option valaue="" >select cities</option>');
              $.each(data.data, function(index,city){
                $("#cities").append('<option value="'+city.id+'">'+city.name.en+'</option>');
              });
            }
          },
          error : function (jqXhr, textStatus, errorMessage){
            alert(errorMessage);
          }
        });
      }
      else
      {
        $("#cities").empty();
        $("#cities").append('<option >المدينة</option>');
      }
    });
  </script>


@endpush
