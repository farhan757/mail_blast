@extends('layouts.app2')

@section('tittlebar','Settings Email System')



@section('css')
    
@endsection
            
@section('content')
<div class="module">
							<div class="module-head">
								<h3>Settings > Form Variable Field</h3>
							</div>
							<div class="loading" id="loading" style="visibility: hidden;">Loading</div>							
								<div class="module-body">
										<form class="form-horizontal row-fluid" name="form-item" id="form-item" method="POST" enctype="multipart/form-data">
										{{ csrf_field() }}	

											<div class="control-group">
												<label class="control-label" for="basicinput">Code</label>
												<div class="controls">
													<input tabindex="1" type="text" data-placeholder="Code" class="span8" id="code" name="code" value="{{ $code ?? '' }}" required>													
													<a href="#" onclick="gencode()" class="btn">GetCode</a>
												</div>
											</div>										

											<div class="control-group">
												<label class="control-label" for="basicinput">Name</label>
												<div class="controls">
													<input tabindex="1" type="text" data-placeholder="Name" class="span8" id="name_mstr" name="name_mstr" value="{{ $name ?? '' }}" required>													
												</div>
											</div>																					  												 											                          

											<div class="control-group">
												<label class="control-label" for="basicinput">Set Variable to Field</label>
												<div class="controls">
													<input tabindex="1" type="text" data-placeholder="Project Name" class="span4" id="variable" name="variable">
													&nbsp To Field &nbsp &nbsp
													<select tabindex="1" data-placeholder="Select here.." class="span3" id="field" name="field">													
														@foreach($field as $val)													
														<option value="{{ $val }}">{{ $val }}</option>
														@endforeach
													</select>																											
												</div>
												
											</div>

											<div class="control-group">
												<button tabindex="4" class="btn"  id="save" type="submit">Submit</button>												
												<a  class="btn" href="#" id="add" onclick="batal()">Cancel</a>																							
											</div>
										</form>																							
											<br>
											<table id="myTable" class="table table-striped table-bordered table-condensed">
												<thead>
													
													<th>#</th>
													<th>Variable</th>
													<th>Field</th>
													<th>Action</th>
													
												</thead>
												<tbody>
													@if(isset($code))
														@foreach($detail as $value)
															<tr>
																<td></td>
																<td>{{ $value->nm_variable }}</td>
																<td>{{ $value->nm_field }}</td>
																<td><a title='Delete' href='#' onclick='deleteItem({{$value->id}})' class='icon-trash'></a></td>
															</tr>
														@endforeach
													@endif
												</tbody>
											</table>											
								</div>
							<!--</form>-->
							
						
</div>
@endsection

@section('js')
<script>	
	/*let lineNo = 1; 
	function addVartoField(){
		var tbody = $('#myTable').children('tbody');
		var table = tbody.length ? tbody : $('#myTable');		
		var variabel = $("#variable").val();
			var toField = $("#field").val();
			
			markup = "<tr>";
			markup +="<td>"+lineNo+"</td>";
			markup+="<td name='vari["+variabel+"]' id='vari["+variabel+"]' value='"+variabel+"' >"+variabel+"</td>";
			markup+="<td name='field[]' id='field[]' value='"+toField+"'>"+toField+"</td>";
			markup+="<td><a title='Delete' href='#' onclick='removeVartoField(this)' class='icon-trash'></a></td>";
			markup+="</tr>";
			
			table.append(markup);	
			lineNo++;		
			$("#variable").val('');
	}

	function removeVartoField(r){
		/*var i = r.parentNode.parentNode.rowIndex;
  		document.getElementById("myTable").deleteRow(i);	*/
	
      function gencode(){
        $.ajax({
          url : "{{ route('gencode') }}",
          type: "GET",
          success: function(data){
            $('#code').val(data);
          }
        });
      }  
	
	function batal(){
		var code = $('#code').val();
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
              url:  "{{ route('settings.varfil.cancel')}}",
              type: "POST",
              data: { "_token": "{{ csrf_token() }}", 'code' : code},
              dataType: "JSON",
              success: function(data) {
                Swal.fire({
                  icon: 'success',
                  title: data.message,
                  onClose: () => {
                    window.location.reload();
                  }
                });
              },
              error : function() {
                Swal.fire({
                  icon:'error',
                  title: 'Error Delete Data'
                });
              }
          });
        }
      });		
	}

    function deleteItem(id) {
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
              url:  "{{route('settings.varfil.deleteItem')}}",
              type: "POST",
              data: { "_token": "{{ csrf_token() }}", 'code' :id},
              dataType: "JSON",
              success: function(data) {
                Swal.fire({
                  icon: 'success',
                  title: data.message,
                  onClose: () => {
                    window.location.reload();
                  }
                });
              },
              error : function() {
                Swal.fire({
                  icon:'error',
                  title: 'Error Delete Data'
                });
              }
          });
        }
      });
    }




    $(function(){ 		

		
		  $('#form-item').submit(function(e) {
        e.preventDefault();

        var url = "{{ route('settings.varfil.save') }}";
          var formData = new FormData($('#form-item')[0]);
          $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData:false,
            success: function(response) {
              //alert(JSON.stringify(response));
              if(response.status==1) {
                  Swal.fire({
                    icon: 'success',
                    title: response.message,
                    onClose: () => {
                      var name = $("#name_mstr").val();
                      var code = $("#code").val();
                      var reidretc = 'show/?_tokenbro={{ csrf_token() }}{{ csrf_token() }}{{ csrf_token() }}&code='+code+'&name='+name;
                      window.location.href = reidretc;
                      aftersave();
                    }
                  });
              } else {
                  Swal.fire({
                    icon: 'error',
                    title: response.message,
                    onClose: () => {
                      
                      aftersave();
                    }
                  });

              }
            },
            error: function(response) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                });
            }
          });
      });
    });
</script>
@endsection