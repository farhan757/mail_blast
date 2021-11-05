@extends('layouts.app2')

@section('tittlebar','Settings Email System')



@section('css')
    
@endsection
            
@section('content')
<div class="module">
							<div class="module-head">
								<h3>Settings > Form Project</h3>
							</div>
							<div class="loading" id="loading" style="visibility: hidden;">Loading</div>							
								<div class="module-body">
										<form  action="@if(isset($edit)) {{ route('settings.project.update',$edit->id) }}  @else {{ route('settings.project.save') }} @endif"  class="form-horizontal row-fluid" name="form-item" id="form-item" method="POST" enctype="multipart/form-data">
										{{ csrf_field() }}											                                                                         
										<div class="control-group">
												<label class="control-label" for="basicinput">Customer</label>
												<div class="controls">
													<select tabindex="1" data-placeholder="Select here.." class="span8" id="customer" name="customer" required>													
														@foreach($customer as $cust)													
														<option value="{{ $cust->id }}"
															@if(isset($edit))
																@if($cust->id === $edit->id)
																	selected
																@endif
															@endif														
														>{{ $cust->cust_name }}</option>
														@endforeach
													</select>
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="basicinput">Project Name</label>
												<div class="controls">
													<input tabindex="2" type="text" data-placeholder="Project Name" class="span8" id="project" name="project" value="{{ $edit->pro_name ?? '' }}" required>
												</div>
											</div> 

											<div class="control-group">
												<label class="control-label" for="basicinput">Desc</label>
												<div class="controls">
													<input tabindex="3" type="text" data-placeholder="Desc" class="span8" id="desc" name="desc" value="{{ $edit->desc ?? '' }}" required>
												</div>
											</div> 																						

											<div class="control-group">
												<label class="control-label" for="basicinput">Body Email</label>
												<div class="controls">
													<select tabindex="4" onchange="getBodyemail()" data-placeholder="Select here.." class="span8" id="body_email" name="body_email" required>
														<option value="0">Select here ..</option>
														@foreach($body as $value)

														<option value="{{$value->id}}"
															@if(isset($edit))
																@if($value->id === $edit->body_mail_id)
																	selected
																@endif
															@endif
														>{{$value->subject}}</option>
														@endforeach
													</select>
												</div>
											</div>   

											<div class="control-group">
												<label class="span15" for="basicinput" id="subject"></label>
											</div> 

											<div class="control-group">												
												<div class="docs-example" id="body">
												</div>
											</div>  												 											                          

											<div class="control-group">
												<button tabindex="5" type="submit" class="btn">Submit</button>
												<b><a tabindex="6" href="{{route('settings.project')}}" class="btn">Cancel</a></b>
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