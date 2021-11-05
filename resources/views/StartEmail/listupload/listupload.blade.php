@extends('layouts.app2')

@section('tittlebar','List Upload Email System')



@section('css')

@endsection
            
@section('content')
<div class="module">
							<div class="module-head">
								<h3>Start Email > Data File Upload</h3>
							</div>
							<div class="module-body table">
							<div class="loading" id="loading" style="visibility: hidden;">Loading&#8230;</div>							
								<table  cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped display" width="100%">
									<thead>
										<tr>
											<th>No</th>
											<th>Customer/Project</th>
											<th>Cycle/Part</th>
											<th>File Name</th>
											<th>Summary Detail</th>
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
											<td>{{$val->cust_name}}/{{$val->pro_name}}</td>
											<td>{{$val->cycle}}/{{$val->part}}</td>
											<td>{{$val->file_name}}</td>
											<td>{{$val->jml}}</td>
											<td>
												<a title="Delete" href="#" onclick="deleteMaster({{ $val->id }})" class="icon-trash"></a>
												<a title="Detail" href="#" onclick="detail({{ $val->id }})" class="icon-laptop" data-toggle="modal"></a>
																							
											</td>
										</tr>
									@endforeach
									</tbody>
									<tfoot>
										<tr>
											<th>No</th>
											<th>Customer/Project</th>
											<th>Cycle/Part</th>
											<th>File Name</th>
											<th>Summary Detail</th>
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
	var rootUrl = 'listupload';

    function deleteMaster(id) {
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.value) {
          $.ajax({
              url: rootUrl+ '/delete/' + id,
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
                  title: 'Error Delete Data'
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
					var stat = 'Approved';
					if(obj.app == 2)
					{
						stat = 'Not Approved';
					}else if(obj.app == 0){
						stat = 'Waiting Approval';
					}

					tbody += `<tr>
						<td>${obj.account}</td>
						<td>${obj.name}</td>
						<td>${obj.to}</td>
						<td>${stat}</td>						
					</tr>`;
				}
				$('#tbody-detail').html(tbody);				
				hideLoad();
			},
			error: function(){
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