@extends('layouts.master')
@section('css')
@if(App::getLocale() == 'en')
    <!--Internal  treeview -->
    <link href="{{URL::asset('assets/plugins/treeview/treeview.css')}}" rel="stylesheet" type="text/css" />
    @else
    <!--Internal  treeview -->
    <link href="{{URL::asset('assets/plugins/treeview/treeview-rtl.css')}}" rel="stylesheet" type="text/css" />
    @endif

<style> 
#gap {
	  column-count:10;
	}
	</style>
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">

					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">Pages</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/  Request Details</span>
						</div>
					</div>

				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row row-sm">
					<div class="col-lg-12">

						<div class="card">
							<div class="card-body">
								<a class="btn btn-primary btn-sm" href="{{route('upgrade_requests.index')}}">{{ trans('lang.back') }}</a>
								<br>
								<br>
							
								<div class="tabs-menu ">
									<!-- Tabs -->
									<ul class="nav nav-tabs profile navtab-custom panel-tabs">
										<li class="active">
											<a href="#home" data-toggle="tab" aria-expanded="true"> <span class="visible-xs"><i class="las la-user-circle tx-16 mr-1"></i></span> <span class="hidden-xs">Upgrade Request</span> </a>
										</li>
										<li class="">
											<a href="#profile" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="las la-images tx-15 mr-1"></i></span> <span class="hidden-xs">GALLERY</span> </a>
										</li>

										@if ( $upgrade_request->status == 'pennding' )
											
											<li class="">
												<a href="#settings" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="las la-cog tx-16 mr-1"></i></span> <span class="hidden-xs">SETTINGS</span> </a>
											</li>
										@endif
									</ul>
								</div>
								<div class="tab-content border-left border-bottom border-right border-top-0 p-4">
									<div class="tab-pane active" id="home">
										<h4 class="tx-15 mb-3">Upgrade Request From <span class="text-primary"> {{optional( $upgrade_request->user)->name }} </span></h4>

                                        
										{{-- <p class="m-b-5">Hi I'm Petey Cruiser,has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt.Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim.</p> --}}
										<div class="m-t-30">
										
                                            <h4 class="tx-15 mt-3">{{ trans('lang.upgrade_request_phone') }}</h4>
											<div class=" p-t-10">
												<h5 class="text-primary m-b-5 tx-14"> {{ $upgrade_request->phone}} </h5>
                                            </div>

											
											<h4 class="tx-15 mt-3">{{ trans('lang.upgrade_request_Orgnization_Name') }}</h4>
											<div class=" p-t-10">
												<h5 class="text-primary m-b-5 tx-14">{{$upgrade_request->organization_name}}</h5>
                                            </div>

											<h4 class="tx-15 mt-3">{{ trans('lang.upgrade_request_Account') }}</h4>
											<div class=" p-t-10">
												<h5 class="text-primary m-b-5 tx-14">{{ optional($upgrade_request->subAccount)->name }}</h5>
                                            </div>

											<h4 class="tx-15 mt-3">{{ trans('lang.upgrade_request_Category') }}</h4>
											<div class=" p-t-10">
												<h5 class="text-primary m-b-5 tx-14">{{ optional($upgrade_request->category)->name }}</h5>
                                            </div>

                                            @if ($upgrade_request->note )
                                            
                                                <hr>
                                                <div class="">
                                                    <h5 class="m-b-5 tx-14">{{ trans('lang.upgrade_request_note') }}</h5>

                                                    <p class="text-muted tx-13 mb-0">{{ $upgrade_request->note }}</p>
                                                </div>
                                            @endif

                                            @if ($upgrade_request->status == 'rejected' )
                                            
                                                <hr>
                                                <div class="">
                                                    <h5 class="m-b-5 tx-14">{{ trans('lang.upgrade_request_Status') }}  <span class=" text-danger"> {{ $upgrade_request->status}} </span> </h5>
                                                    <h5 class="m-b-5 tx-14"> {{ trans('lang.upgrade_request_reason') }} </h5>

													<p class="text-muted tx-13 mb-0">{{ $upgrade_request->rejected_reason }}</p>
                                                </div>

											@elseif($upgrade_request->status == 'accepted')

												<hr>
                                                <div class="">
                                                    <h5 class="m-b-5 tx-14">{{ trans('lang.upgrade_request_Status') }}  <span class=" text-success"> {{ $upgrade_request->status}} </span> </h5>
                                                </div>

                                            @endif


										</div>
									</div>
									<div class="tab-pane" id="profile">
										<div class="row">

                                            @foreach ($upgrade_request->medias as $image)
                                                
                                                <div class="col-sm-3">

                                                    <div class="border p-1 card thumb">
                                                        <a href="{{ URL::asset($image->path) }}" target="_blank" class="image-popup" title="Screenshot-2"> <img src="{{URL::asset($image->path)}}" class="thumb-img" alt="work-thumbnail" height="100%"> </a>
                                                        
                                                    </div>
                                                </div>
                                            @endforeach
											
										</div>
									</div>

									<div class="tab-pane" id="settings">

										<div class="row">

											<div class="col-lg-4">

												<label class="rdiobox">

												<input  id="radio_accept" type="radio" name="action_of_request" value="radio_accept"> <span> {{ trans('lang.upgrade_request_accept') }}

												</label>
												<br>
												<div class="" id="div_accept"  style="display:none">

													<form action="{{route('upgrade_requests.accepted',$upgrade_request->id)}}" method="post" enctype="multipart/form-data">
														{{ csrf_field() }}
									
														<div class="">
                                                             
															<br>
							

															@inject('accounts','App\Models\Account')
							
															<ul id="treeview1">
							
																@foreach ($accounts->get() as $account)
																
																	<li id="account"> 
																		<a href="#">{{$account->name}}</a>
																		
																		<ul>
																			@foreach ($account->subAccounts()->get() as $sub_account)
																	
																				<li id="sub_account" >
																					
																					<input id="sub_account"  type="checkbox" style="margin:3px" @if( $personal_id == $sub_account->id ) checked  checked onclick="return false;" class="personal" @endif   name="sub_account[]" value="{{$sub_account->id}}" class="m-2">{{$sub_account->name}}
																					
																				</li>
							
																			@endforeach
																		</ul>
																	</li>
																@endforeach
															</ul>
																
															<div class="col-sm-5 modal-footer">
																<button type="submit" class="btn btn-primary">{{ trans('lang.upgrade_request_Save') }}</button>
																<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('lang.upgrade_request_Close') }}</button>
															</div>
															
														</div>
													</form>
												</div>
											</div>

											<div class="col-lg-4">
													<label class="rdiobox">
														<input  id="radio_reject" type="radio" name="action_of_request" value="radio_reject" checked><span>{{ trans('lang.upgrade_request_rejected') }}  </span>
												</label>

													<div class=""  id="div_reject"   style="display:inline" >

														<h5 class="modal-title" id="exampleModalLabel">{{ trans('lang.upgrade_request_reason_rejected') }} </h5>
														<br>
														<form action="{{route('upgrade_requests.rejected',$upgrade_request->id)}}" method="post" enctype="multipart/form-data">
															{{ csrf_field()}}
										
															<div class="form-group ">
																<textarea   class="form-control" data-parsley-class-handler="#lnWrapper"
																name="rejected_reason" required placeholder="reject reson">{{$upgrade_request->rejected_reason}}</textarea>
															</div>
														
										
															<div class="">
																<button type="submit" class="btn btn-primary">{{ trans('lang.upgrade_request_Save') }}</button>
																<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('lang.upgrade_request_Close') }}</button>
															</div>
														</form>


													</div>

												</div>

											
											</div>
										</div>
							    	</div>
							</div>
						</div>
					</div>
				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
@endsection

@push('script')
<script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>

	<script>

		$('li#sub_account').css("display", "block");

		$('input[type="radio"]').on( 'change' ,function()
		{
			var value = $(this).val();
	
			if(value === "radio_reject")
			{

				$('#div_reject').css('display','inline');
				$('#div_accept').css('display','none');
			}
			else
			{
				$('#div_reject').css('display','none');
				$('#div_accept').css('display','inline');
			}


	
	
		});
		
		
		$('input#sub_account').on('change', function(){

           $('input').not('.personal').prop('checked', false);
		   $(this).prop('checked', true);
		   
        })
		
	</script>
@endpush
