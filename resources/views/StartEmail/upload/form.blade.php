@extends('layouts.app2')

@section('tittlebar','Start Upload Email System')



@section('css')
    
@endsection
            
@section('content')
<div class="module">
							<div class="module-head">
								<h3>Start Email > Forms Upload File</h3>
							</div>
							<div class="loading" id="loading" style="visibility: hidden;">Loading</div>							
								<div class="module-body">
										<form class="form-horizontal row-fluid" name="form-item" id="form-item" enctype="multipart/form-data">
										{{ csrf_field() }}
											<div class="control-group">
												<label class="control-label" for="basicinput">Customer</label>
												<div class="controls">
													<select onchange="getProject()" tabindex="1" data-placeholder="Select here.." class="span8" id="customer" name="customer" required>													
														@foreach($customer as $cust)													
														<option value="{{ $cust->id }}">{{ $cust->cust_name }}</option>
														@endforeach
													</select>
												</div>
											</div>
											
											<div class="control-group">
												<label class="control-label" for="basicinput">Project</label>
												<div class="controls">
													<select tabindex="2" data-placeholder="Select here.." class="span8" id="project" name="project" required>
														<option value="">Select here..</option>
													</select>
												</div>
											</div> 

											<div class="control-group">
												<label class="control-label" for="basicinput">Part</label>
												<div class="controls">
													<select tabindex="3" data-placeholder="Select here.." class="span8" id="part" name="part" required>												
														@for($i=1; $i <= 10; $i++)
															<option value="{{ $i }}">{{ $i }}</option>																									
														@endfor
													</select>
												</div>
											</div>                                         
																				
											<div class="control-group">
												<label class="control-label" for="basicinput">Cycle</label>
												<div class="controls">
													<input tabindex="4" name="datepicker" type="text" id="datepicker" placeholder="yyyymmdd" class="span4" required>												
												</div>
											</div>

											<div class="control-group">
												<label class="control-label" for="basicinput">Select File</label>
												<div class="controls">
													<input tabindex="5" id="file" name="file" data-title="A tooltip for the input" type="file" placeholder="Hover to view the tooltip…" data-original-title="" class="span8 tip" required>
												</div>
											</div>                                    

											<!--<div class="control-group">
												<label class="control-label" for="basicinput">Desc</label>
												<div class="controls">
													<textarea tabindex="6" id="desc" name="desc" class="span8" rows="5"></textarea>
												</div>
											</div>-->

											<div class="control-group">
												<div class="controls">
													<a tabindex="7" href="#" onclick="submit()" class="btn">Submit</a>
												</div>
											</div>
										</form>
								</div>
							
						
</div>
@endsection

@section('js')
<script>
	var url = 'upload';
	getProject();
	restore();

	function restore(){
		document.getElementById("file").value = "";
		document.getElementById("datepicker").value = "";
		document.getElementById("desc").value = "";
		document.getElementById("part").value = "";
	}

	function getProject(){
		var idCust = $('#customer').val();
		var route = "{{ route('getproject','idCust') }}";
		route = route.replace('idCust',idCust);
		$.ajax({
			url : route,
			method : 'GET',
			success : function(response){
				var html = "";
				for(var i=0; i < response.length; i++){
					var data = response[i];
					console.log(data.pro_name);
					html += "<option value="+data.id+">"+data.pro_name+"</option>";
				}
				$('#project').replaceWith($('#project').html(html));
			},
			error : function(){
				alert('error');
			}
		});
	}

	function submit(){
		var formData = new FormData($('#form-item')[0]);
			showLoad();
			$.ajax({
				url: url+'/pro',
				type: 'POST',
				data: formData,
				contentType: false,
            	processData:false,	
				success: function(respon){
					if(respon.status == 1){
						hideLoad()
						Swal.fire({
							icon: 'success',
							title: respon.message,
							onClose: () => {
							window.location.reload();
							}
						});
					}else{
						hideLoad()
						Swal.fire({
							icon: 'error',
							title: respon.message,
							onClose: () => {
							window.location.reload();
							}
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
			});		
	}

    $(function(){ 


    });
</script>
@endsection