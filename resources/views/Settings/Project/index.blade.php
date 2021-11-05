@extends('layouts.app2')

@section('tittlebar','List Project Email System')



@section('css')

@endsection
            
@section('content')
<div class="module">
							<div class="module-head">
								<h3>Settings > List Project</h3>
							</div>
                            <div class="module-body">
                                <b><a href="{{ route('settings.project.form') }}" class="icon-plus btn"><span class="success"> Add</span></a></b>
                            </div>
							<div class="module-body table">
							<div class="loading" id="loading" style="visibility: hidden;">Loading&#8230;</div>							
								<table  cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped display" width="100%">
									<thead>
										<tr>
											<th>No</th>
											<th>Customer</th>
                                            <th>Project</th>
                                            <th>Id Body Email</th>                                            
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
											<td>{{$val->cust_name}}</td>
                                            <td>{{$val->pro_name}}</td>
                                            <td>{{$val->body_mail_id}}</td>                                            
											<td>
												<a title="Delete" href="#" onclick="deleteMaster({{ $val->id }})" class="icon-trash"></a>																						
                                                <a title="Edit" href="{{ route('settings.project.edit',$val->id) }}" class="icon-edit"></a>																						
											</td>
										</tr>
									@endforeach
									</tbody>
									<tfoot>
										<tr>
											<th>No</th>
											<th>Customer</th>
                                            <th>Project</th>
                                            <th>Id Body Email</th>                                            
											<th>Action</th>
										</tr>
									</tfoot>
								</table>							
							</div>

</div>

@endsection

@section('js')
<script>
	var rootUrl = 'project';

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

</script>
@endsection