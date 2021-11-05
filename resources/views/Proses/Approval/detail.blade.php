          <!-- sample modal content -->
          							
          <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="loading" id="loading" style="visibility: hidden;">Loading&#8230;</div>
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h3 id="myModalLabel">Modal Heading</h3>
            </div>
            <div class="modal-body">                
                  <dt class="col-4">Customer</dt>
                  <dd class="col-8" id="customer"></dd>
                  <dt class="col-4">Project</dt>
                  <dd class="col-8" id="project"></dd>
                  <dt class="col-4">Cycle/Part</dt>
                  <dd class="col-8" id="cycpart"></dd>
                  <dt class="col-4">Total</dt>
                  <dd class="col-8" id="total"></dd>
                  <dt class="col-4">Upload by</dt>
                  <dd class="col-8" id="by"></dd>
                  <dt class="col-4">Created at</dt>
                  <dd class="col-8" id="created_at"></dd>
                  <br>
                <div class="module-head">
                  <h3>Data Detail</h3>
                </div>
                <div class="module-body table">                  
                    <table class="table table-bordered table-striped display" width="100%">
                      <thead>
                        <tr>
                          <th>Account</th>
                          <th>Name</th>
                          <th>To</th>
                          <th>Note</th>                          
                        </tr>
                      </thead>
                      <tbody id="tbody-detail">

                      </tbody>

                    </table>							
                </div>                  
          </div>
            <div class="modal-footer">
              <button class="btn" data-dismiss="modal">Close</button>              
            </div>
          </div>