@extends('layouts.app2')

@section('tittlebar','Settings Email System')



@section('css')
    
@endsection
            
@section('content')
<div class="module">
							<div class="module-head">
								<h3>Settings > Form User</h3>
							</div>
							<div class="loading" id="loading" style="visibility: hidden;">Loading</div>							
								<div class="module-body">
										<form  action="@if(isset($edit)) {{ route('settings.project.update',$edit->id) }}  @else {{ route('register') }} @endif"  class="form-horizontal row-fluid" name="form-item" id="form-item" method="POST" enctype="multipart/form-data">
										{{ csrf_field() }}											                                                                         
										<div class="control-group">
												<label class="control-label" for="basicinput">Customer</label>
												<div class="controls">
													<select tabindex="1" data-placeholder="Select here.." class="span8" id="customer" name="customer" required>
														<option value="0">Internal</option>
														@foreach($customer as $cust)													
														<option value="{{ $cust->id }}"
															@if(isset($edit))
																@if($cust->id === $edit->customer_id)
																	selected
																@endif
															@endif														
														>{{ $cust->cust_name }}</option>
														@endforeach
													</select>
												</div>
											</div>
											
										<div class="control-group">
											<label for="name" class="control-label">{{ __('Name') }}</label>

											<div class="controls">
												<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

												@error('name')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
											</div>
										</div>

										<div class="control-group">
											<label for="email" class="control-label">{{ __('E-Mail Address') }}</label>

											<div class="controls">
												<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

												@error('email')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
											</div>
										</div>

										<div class="control-group">
											<label for="password" class="control-label">{{ __('Password') }}</label>

											<div class="controls">
												<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

												@error('password')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
											</div>
										</div>

										<div class="control-group">
											<label for="password-confirm" class="control-label">{{ __('Confirm Password') }}</label>

											<div class="controls">
												<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
											</div>
										</div>

										<div class="control-group">
											<div class="control-label">
												<button type="submit" class="btn btn-primary">
													{{ __('Register') }}
												</button>
											</div>
										</div>	
									</form>
									
								</div>
							
						
</div>
@endsection

@section('js')
<script>
	var urls = 'project';

    $(function(){ 

		/*$('#form-item').submit(function(event){
			event.preventDefault();
			var data = CKEDITOR.instances.konten.getData();			
			showLoad();
			$.ajax({
				url: url,
				type: 'POST',
				data: {
					'konten' : data
				},
            	processData:false,	
				success: function(respon){
					if(respon.status == 1){
						hideLoad()
						Swal.fire({
							icon: 'success',
							title: respon.message,

						});
					}else{
						hideLoad()
						Swal.fire({
							icon: 'error',
							title: respon.message,

						});						
					}
					
				},
				error: function(response) {
					hideLoad();
						Swal.fire({
							icon: 'error',
							title: 'Error',
						});
				}							
			})
		});*/
    });
</script>
@endsection