@extends('layouts.app2')

@section('tittlebar','Settings Email System')



@section('css')
    
@endsection
            
@section('content')
<div class="module">
							<div class="module-head">
								<h3>Settings > Form Customer</h3>
							</div>
							<div class="loading" id="loading" style="visibility: hidden;">Loading</div>							
								<div class="module-body">
										<form  action="@if(isset($edit)) {{ route('settings.customer.update',$edit->id) }}  @else {{ route('settings.customer.save') }} @endif"  class="form-horizontal row-fluid" name="form-item" id="form-item" method="POST" enctype="multipart/form-data">
										{{ csrf_field() }}											                                                                         
										<div class="control-group">
												<label class="control-label" for="basicinput">Customer</label>
												<div class="controls">
												<input tabindex="1" type="text" data-placeholder="Project Name" class="span8" id="customer" name="customer" value="{{ $edit->cust_name ?? '' }}" required>
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="basicinput">Alamat</label>
												<div class="controls">
													<textarea tabindex="2" type="text" data-placeholder="Alamat" row="5" class="span8" id="alamat" name="alamat" required>{{ $edit->cust_alamat ?? '' }}</textarea>
												</div>
											</div> 

											<div class="control-group">
												<label class="control-label" for="basicinput">Telphone</label>
												<div class="controls">
													<input tabindex="3" type="text" data-placeholder="Telphone" class="span8" id="telp" name="telp" value="{{ $edit->cust_telp ?? '' }}" required>
												</div>
											</div> 																						  												 											                          

											<div class="control-group">
												<button tabindex="4" type="submit" class="btn">Submit</button>
												<b><a tabindex="5" href="{{route('settings.customer')}}" class="btn">Cancel</a></b>
											</div>	
										</form>
									
								</div>
							
						
</div>
@endsection

@section('js')
<script>
	var urls = 'project';
	getBodyemail();
	function getBodyemail(){
		var id = $('#body_email').val();
		$.ajax({
			url : 'getbodyEmail/'+id,
			type : 'GET',
			success : function(data){
				if(data.status == 1){
					$('#subject').replaceWith($('#subject').html(data.data.subject));
					$('#body').replaceWith($('#body').html(data.data.body_mail));
				}else{
					$('#subject').replaceWith($('#subject').html(''));
					$('#body').replaceWith($('#body').html(''));					
				}
			},			
		});
	}

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