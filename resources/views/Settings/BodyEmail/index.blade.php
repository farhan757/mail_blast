@extends('layouts.app2')

@section('tittlebar','List Body Mail Email System')



@section('css')

@endsection
            
@section('content')
<div class="module">
							<div class="module-head">
								<h3>Settings > List Body Mail</h3>
							</div>
                            <div class="module-body">
                                <b><a href="{{ route('settings.bodyemail.show') }}" class="icon-plus btn"><span class="success"> Add</span></a></b>
                            </div>
							<div class="module-body table">
							<div class="loading" id="loading" style="visibility: hidden;">Loading&#8230;</div>							
								<table  cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped display" width="100%">
									<thead>
										<tr>
											<th>No</th>
											<th>Subject</th>
                                            <th>Create/Update by</th>
                                            <th>Created_at</th>
                                            <th>Updated_at</th>
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
											<td>{{$val->subject}}</td>
                                            <td>{{$val->name}}</td>
                                            <td>{{$val->created_at}}</td>
                                            <td>{{$val->updated_at}}</td>
											<td>
												<a title="Delete" href="#" onclick="deleteMaster({{ $val->id }})" class="icon-trash"></a>																						
                                                <a title="Edit" href="{{ route('settings.bodyemail.showid',$val->id) }}" class="icon-edit"></a>																						
											</td>
										</tr>
									@endforeach
									</tbody>
									<tfoot>
										<tr>
                                            <th>No</th>
											<th>Subject</th>
                                            <th>Create/Update by</th>
                                            <th>Created_at</th>
                                            <th>Updated_at</th>
											<th>Action</th>
										</tr>
									</tfoot>
								</table>							
							</div>

</div>

@endsection

@section('js')
<script>
	var rootUrl = 'body-email';

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