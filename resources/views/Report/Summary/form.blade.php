@extends('layouts.app2')

@section('tittlebar','Report Export Email System')



@section('css')
    
@endsection
            
@section('content')
<div class="module">
							<div class="module-head">
								<h3>Report Email > Summary Export</h3>
							</div>
							<div class="loading" id="loading" style="visibility: hidden;">Loading</div>							
								<div class="module-body">
										<form class="form-horizontal row-fluid" name="form-item" id="form-item" method="POST" action="{{ route('report.summary.export') }}">
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
												<label class="control-label" for="basicinput">Date</label>
												<div class="controls">
													<input tabindex="2" name="cyc1" type="text" id="cyc1" placeholder="yyyy-mm-dd" class="span4" required>
													s/d
													<input tabindex="3" name="cyc2" type="text" id="cyc2" placeholder="yyyy-mm-dd" class="span4" required>												
												</div>
											</div>

											<div class="control-group">
												<div class="controls">
													<button tabindex="4" type="submit" class="btn-inverse">Export</button>
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

	/*function getProject(){
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
	}*/

    $(function(){ 
		/*$('#form-item').submit(function(event){
			event.preventDefault();
			var formData = new FormData($('#form-item')[0]);
			showLoad();
			$.ajax({
				url: url,
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
			})
		});*/
    });
</script>
@endsection