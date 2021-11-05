@extends('layouts.app2')

@section('tittlebar','List Data No Approval Email System')



@section('css')

@endsection
            
@section('content')
<div class="module">
							<div class="module-head">
								<h3>Proses > List Data No Approval</h3>
							</div>
							<div class="module-body table">
							<div class="loading" id="loading" style="visibility: hidden;">Loading&#8230;</div>							
								<table  cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped display" width="100%">
									<thead>
										<tr>											
											<th>No</th>
											<th>No Account</th>
											<th>Name</th>
											<th>To</th>	
											<th>Password PDF</th>										
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
											<th>{{$val->password_attach}}</th>
											<td>
												<a title="Detail" href="#" onclick="detail({{ $val->id }})" class="icon-laptop" data-toggle="modal"></a>																							
											</td>
										</tr>
									@endforeach
									</tbody>
									<tfoot>
										<tr>											
											<th>No</th>
											<th>No Account</th>
											<th>Name</th>
											<th>To</th>
											<th>Password PDF</th>											
											<th>Action</th>
										</tr>
									</tfoot>
								</table>							
							</div>

</div>

@include('Proses.NotSent.detail')
@endsection

@section('js')
<script>
	var rootUrl = 'noapproval';

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

    $(function(){ 
        $('#datepicker').datepicker({
          autoclose: true,
          format: "yyyymmdd"
        });
    });
</script>
@endsection