          <!-- sample modal content -->
          							
          <div id="modalresend" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="loading" id="loading" style="visibility: hidden;">Loading&#8230;</div>
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h3 id="myModalhead">Modal Heading</h3>
            </div>
            <div class="modal-body">   
              <form class="form-horizontal row-fluid" name="form-item" id="form-item" method="POST" > 
              {{ csrf_field() }}
              <input type="hidden" name="id" id="id">
                      <div class="control-group">
												<label class="control-label" for="basicinput">New Email</label>
												<div class="controls">
													<input tabindex="1" name="email" type="email" id="email" placeholder="example@domain.com" class="span9" required>												
												</div>
											</div>  
                      <div class="control-group">
												<label class="control-label" for="basicinput">Desc</label>
												<div class="controls">
													<input tabindex="1" name="desc" type="text" id="desc"  class="span9" required>												
												</div>
											</div>                                              
              </form>                  
                  <br>                 
          </div>
            <div class="modal-footer">
              <button class="btn-inverse" data-dismiss="modal">Close</button>  
              <button class="btn-inverse" onclick="submitResend()">Submit</button>              
            </div>
            
          </div>