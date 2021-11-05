@extends('layouts.app2')

@section('tittlebar','List Data Sending Email System')



@section('css')

@endsection
            
@section('content')
<div class="module">
							<div class="module-head">
								<h3>Progress > List Data Sending</h3>
							</div>						
							<div class="module-body table">
							<div class="loading" id="loading" style="visibility: hidden;">Loading&#8230;</div>							
								<table  cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped display" width="100%">
									<thead>
										<tr>											
											<th>No</th>
											<th>No Account</th>
											<th>Name</th>
											<th>Email</th>											
											<th>Status Sent</th>	
											<th>Read Count</th>
											<th>Sent at</th>																				
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									@php
										$cntr =0;
									@endphp
									@foreach($data as $val)
										@php
											$cntr++;
										@endphp									
										<tr>											
											<td>{{ $cntr }}</td>
											<td>{{$val->account}}</td>
											<td>{{$val->name}}</td>	
											<td>{{$val->to}}</td>										
											<td >
											@if($val->sent == 1)
												<a title="Success" href="#" class="icon-check" ></a>	
											@else
												@if($val->sent == 0)
													<a title="Sending.." href="#" class="icon-time" ></a>
												@else
													<a title="{{ $val->msg_error_send }}" href="#" class="icon-remove" ></a>
												@endif										
											@endif
											</td>
											<td>{{$val->read}}</td>
											<td>{{$val->send_at}}</td>											
											<td>																								
												<a title="Detail" href="#" onclick="detail({{ $val->id }})" class="icon-laptop" data-toggle="modal"></a>
												<a title="Resend" href="#" onclick="resending({{ $val->id }})" class="icon-repeat" data-toggle="modal"></a>
											</td>
										</tr>
									@endforeach
									</tbody>
									<tfoot>
										<tr>											
											<th>No</th>
											<th>No Account</th>
											<th>Name</th>
											<th>Email</th>											
											<th>Status Sent</th>	
											<th>Read Count</th>
											<th>Sent at</th>																				
											<th>Action</th>
										</tr>
									</tfoot>
								</table>							
							</div>

</div>

@include('Progress.Sending.detail')
@include('Progress.Sending.formresend')
@endsection

@section('js')
<script>
	var rootUrl = 'sending';

	function reset() {
		$('#email').val('');
		$('#desc').val('');			
	}

	function detail(id){
		showLoad();		
		$.ajax({
			url: rootUrl+'/detail/'+id,
			type : 'POST',
			data: { "_token": "{{ csrf_token() }}", },
          	dataType: "JSON",
			success: function(data){				
				$('#myModal').modal('show');
				$('#myModalLabel').text('Detail '+data.data.account);

				$('#name').text(data.data.name);
				$('#account').text(data.data.account);
				$('#to').text(data.data.to);
				$('#sent_at').text(data.data.send_at);
				$('#by').text(data.data.username);
				$('#app_at').text(data.data.created_at);
				$('#msg').text(data.data.msg_error_send);
			
				hideLoad();
			},
			error: function(){
				Swal.fire({
						icon:'error',
						title: 'No Data Found',						
				});
				hideLoad();	
			}
		});
	}

	function resending(id){
		showLoad();		
		$.ajax({
			url: rootUrl+'/detail/'+id,
			type : 'POST',
			data: { "_token": "{{ csrf_token() }}", },
          	dataType: "JSON",
			success: function(data){				
				$('#modalresend').modal('show');
				$('#myModalhead').text('Resending '+data.data.account);

				$('#id').val(data.data.id);
				reset();		
				hideLoad();
			},
			error: function(){
				Swal.fire({
						icon:'error',
						title: 'No Data Found',						
				});
				hideLoad();	
				reset()
			}
		});
	}	

	function submitResend() {
		var id = $('#id').val();
		var email = $('#email').val();
		var desc = $('#desc').val();
		showLoad();

		$.ajax({
			url: rootUrl+'/resend',
			type: "POST",
			data: {
				'id': id,
				'email': email,
				'desc': desc,
				"_token": "{{ csrf_token() }}",
			},
			success: function(data) {
				if(data.status == 1){
					Swal.fire({
						icon:'success',
						title: data.message,
						onClose: () => {
							window.location.reload();
						}			
					});
				}else if(data.status == 2){
					Swal.fire({
						icon:'error',
						title: data.message,
						onClose: () => {
							window.location.reload();
						}			
					});
				}
				hideLoad();				
			},
			error: function() {
				Swal.fire({
					icon:'error',
					title: 'error',
					onClose: () => {
						window.location.reload();
					}			
				});
				hideLoad();					
			}
		});


	}

</script>
@endsection