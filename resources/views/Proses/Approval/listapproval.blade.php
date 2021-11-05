@extends('layouts.app2')

@section('tittlebar','List Data Approval Email System')



@section('css')

@endsection
            
@section('content')
<div class="module">
							<div class="module-head">
								<h3>Proses > List Data Approval</h3>
							</div>
							<div class="module-body table">
							<div class="loading" id="loading" style="visibility: hidden;">Loading&#8230;</div>							
								<table  cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped display" width="100%">
									<thead>
										<tr>
											<th>Check</th>
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
											<td><input type="checkbox" name="checkbox[{{ $loop->iteration-1 }}]" value="{{ $val->id }}" id="app-{{ $val->id }}"></td>
											<td>{{ $cntr }}</td>
											<td>{{$val->account}}</td>
											<td>{{$val->name}}</td>											
											<td>{{$val->to}}</td>
											<th>{{$val->password_attach}}</th>
											<td>
												<a title="Approve" href="#" onclick="ApproveWithId({{ $val->id }})" class="icon-check"></a>
												<a title="NotApprove" href="#" onclick="NotApproveWithId({{ $val->id }})" class="icon-remove"></a>
												<a title="DownloadPDF" href="{{ route('proses.approval.downloadpf',$val->id) }}" class="icon-download" ></a>																							
												<!--<a title="Detail" href="#" onclick="detail({{ $val->id }})" class="icon-laptop" data-toggle="modal"></a>-->																							
											</td>
										</tr>
									@endforeach
									</tbody>
									<tfoot>
										<tr>
											<th>Check</th>
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

@include('StartEmail.listupload.detail')
@endsection

@section('js')
<script>
	var rootUrl = 'approval';

    function NotApproveWithId(id) {
      Swal.fire({
        title: 'Are you sure?',
        text: "You Won NotApprove this Data !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, NotApprove it!'
      }).then((result) => {
        if (result.value) {
          $.ajax({
              url: rootUrl+ '/NoappWithid/' + id,
              type: "POST",
              data: { "_token": "{{ csrf_token() }}", },
              dataType: "JSON",
              success: function(data) {
				if(data.status === 1){
					Swal.fire({
						icon: 'success',
						title: data.message,
						onClose: () => {
							window.location.reload();
						}
						});	
					console.log(data.message);				
				}else{
					Swal.fire({
						icon:'error',
						title: data.message,
						onClose: () => {
							window.location.reload();
						}						
						});					
				}
              },
              error : function() {
                Swal.fire({
                  icon:'error',
                  title: 'Error NotApprove Data'
                });
              }
          });
          //window.location.reload();
        }
      })
    }

    function ApproveWithId(id) {
      Swal.fire({
        title: 'Are you sure?',
        text: "You Won Approve this Data !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Approve it!'
      }).then((result) => {
        if (result.value) {
          $.ajax({
              url: rootUrl+ '/appWithid',
              type: "POST",
              data: { "_token": "{{ csrf_token() }}", "id" :id},
              dataType: "JSON",
              success: function(data) {
				if(data.status === 1){
					Swal.fire({
						icon: 'success',
						title: data.message,
						onClose: () => {
							window.location.reload();
						}
						});	
					console.log(data.message);				
				}else{
					Swal.fire({
						icon:'error',
						title: data.message,
						onClose: () => {
							window.location.reload();
						}						
						});					
				}
              },
              error : function() {
                Swal.fire({
                  icon:'error',
                  title: 'Error Approve Data'
                });
              }
          });
          //window.location.reload();
        }
      })
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
				$('#myModalLabel').text('Detail '+data.data.file_name);

				$('#customer').text(data.data.cust_name);
				$('#project').text(data.data.pro_name);
				$('#cycpart').text(data.data.cycle+"/"+data.data.part);
				$('#total').text(data.count);
				$('#by').text(data.data.username);
				$('#created_at').text(data.data.created_at);

				var tbody = '';
				for(var i=0, l = data.detail.length; i< l; i++) {
					var obj = data.detail[i];
					tbody += `<tr>
						<td>${obj.account}</td>
						<td>${obj.name}</td>
						<td>${obj.to}</td>
						<td></td>						
					</tr>`;
				}
				$('#tbody-detail').html(tbody);				
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