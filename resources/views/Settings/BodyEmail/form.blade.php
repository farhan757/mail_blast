@extends('layouts.app2')

@section('tittlebar','Settings Email System')



@section('css')
    
@endsection
            
@section('content')
<div class="module">
							<div class="module-head">
								<h3>Settings > Body Email</h3>
							</div>
							<div class="loading" id="loading" style="visibility: hidden;">Loading</div>							
								<div class="module-body">
										<form  action="@if(isset($data)) {{ route('settings.bodyemail.update',$data->id) }}  @else {{ route('settings.bodyemail.save') }} @endif"  class="form-horizontal row-fluid" name="form-item" id="form-item" method="POST" enctype="multipart/form-data">
										{{ csrf_field() }}	

											<div class="control-group">												
												<select tabindex="1" onchange="getSet()" data-placeholder="Select here.." class="span3" id="setting" name="setting">													
														<option value="0">Select here</option>
														@foreach($setting as $val)													
														<option value="{{ $val->id }}" 
														@if(isset($data))
															@if($data->mv_id == $val->id)
																selected
															@endif
														@endif
														>{{ $val->name }}</option>
														@endforeach
												</select>

												<div class="docs-example">
													<table class="table">
														<thead>
															<tr>															
																<th>Variable Name</th>
																<th>Field Name</th>
															</tr>														
														</thead>
														<tbody id="keterangan">

														</tbody>
													</table>
												</div>													
											</div>																				                                                                         
											<div class="control-group">												
												<input tabindex="1" name="subject" type="text" id="subject" placeholder="Subject Email" class="span12" value="{{ $data->subject ?? '' }}" required >												
											</div>
											<div class="control-group">												
												<textarea tabindex="2" id="konten" name="konten" class="span8" rows="5">{{ $data->body_mail ?? '' }}</textarea>
											</div>

											<div class="control-group">
												<b><a tabindex="3" href="{{route('settings.bodyemail')}}" class="btn">Cancel</a></b>
											</div>	
										</form>
									
								</div>
							
						
</div>
@endsection

@section('js')
<script src="{{asset('assets/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('assets/ckeditor/adapters/jquery.js')}}"></script>
<script>
	var url = 'body-email';
	var route_prefix = "{{ url('') }}/filemanager";
	editor();
	function editor(){
		var konten = document.getElementById("konten");
			CKEDITOR.replace(konten,{

							
				filebrowserImageBrowseUrl: route_prefix + '?type=Images',
				filebrowserImageUploadUrl: route_prefix + '/upload?type=Images&_token={{csrf_token()}}',
				filebrowserBrowseUrl: route_prefix + '?type=Files',
				filebrowserUploadUrl: route_prefix + '/upload?type=Files&_token={{csrf_token()}}'		
		});
		CKEDITOR.config.allowedContent = true;	
	}
	getSet();
	function getSet(){
		var id = $('#setting').val();
		$.ajax({
			url: "{{route('getset')}}",
			type: "GET",
			data: {
				"id": id,
			},
			success: function(data){
				var tmp = "";
				$.each(data.data,function(index,value){
					tmp += "<tr>";
					tmp += "<td>"+value['nm_variable']+"</td>";
					tmp += "<td>"+value['nm_field']+"</td>";
					tmp += "</tr>";
				});
				$('#keterangan').replaceWith($('#keterangan').html(tmp));
			}
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