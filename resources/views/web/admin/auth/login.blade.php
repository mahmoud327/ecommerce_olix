@extends('layouts.master2')
@section('css')
<!-- Sidemenu-respoansive-tabs css -->
<link href="{{URL::asset('assets/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css')}}" rel="stylesheet">
@endsection
@section('content')
		<div class="container-fluid">
				
				
				<!-- The content half -->
				<div class="col-md-12 col-lg-10 col-xl-12 bg-white">
					
					<div class="login d-flex align-items-center py-2">
					
						<!-- Demo content-->
						<div class="container p-0">
							
						  
						<div class="card-body login-card-body">
						  @if ($errors->any())
							  <div class="alert alert-danger">
								  <ul>
									  @foreach ($errors->all() as $error)
										  <li>{{ $error }}</li>
									  @endforeach
								  </ul>
							  </div>
						  @endif
							<div class="row">
								<div class="mx-auto" style="margin-bottom:150px; ">
									<div class="card-sigin">
										<img src="{{asset('Suiiz.jpg')}}" class="sign-favicon" alt="logo" style="width:340px;">
										<div class="mb-5 d-flex"> 
											
												
												<h1  style="margin-left:80px;font-size:70px;font-family:serif;">Su<span>ii</span>z</h1></div>
										<div class="card-sigin">
											<div class="main-signup-header">
											    <div style="margin-left:65px">
													<h2>Welcome back!</h2>
													<h5 class="font-weight-semibold mb-4">Please sign in to continue.</h5>
											     </div>
                                                <form method="POST" action="{{ route('admin.loginCheck') }}">
                                                    @csrf
													<div class="form-group">
														<label></label> <input class="form-control" placeholder="Enter your email" name="email" type="text">

                                                        @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
													</div>
                                                    
													<div class="form-group">
														<label></label> <input class="form-control" name="password" placeholder="Enter your password" type="password">

                                                        @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                        
													</div><button class="btn btn-main-primary btn-block">Sign In</button>
													
												</form>
												
                                        
											</div>
										</div>
									</div>
								</div>
							</div>
						</div><!-- End -->
					</div>
				</div><!-- End -->
			</div>
		</div>
@endsection
@section('js')
@endsection