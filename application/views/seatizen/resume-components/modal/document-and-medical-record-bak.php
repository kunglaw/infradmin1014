<div id="data-table-document" class="panel panel-default">
    	<div class="panel-body">
        <h4> Document and Medical Record <button class="btn btn-primary btn-sm pull-right" id="document-btn" modal="form-add-document"> <span class="glyphicon glyphicon-plus"></span> Add </button></h4>
         <?php //$this->load->view('form-add-experience')?>
          <div class="" style="width:100%">
          <br />
            <table class="table table-bordered hover" style="font-size:12px">
              <thead style="font-weight:bold; " class="bg-primary">
              <tr>
                <td width="">Type</td>
                <td width="">Number </td>
                <td>Place</td>
                
                <td>Date Issued</td>
                <td>Date Expired</td>
               
                <td width="15%">Action</td>
              </tr>
             </thead>
             <tbody>
              <?php
             
              
			  foreach($document as $row)
			  {
                      
				  $date_issued = date("M d, Y",strtotime($row['date_issued']));
				  $date_expired = date("M d, Y",strtotime($row['date_expired']));
                       
              ?>
              <tr>
                <td><?php echo $row['type']  ?></td>
                <td><?php echo $row['number'] ?> </td>
                <td><?php  echo $row['place'] ?> </td>
                
                <td><?php echo $date_issued ?></td>
                <td><?php echo $date_expired ?></td>
                <td> 
                  <button class="btn btn-default btn-xs document-update-btn-<?php echo $row['document_id']?>" modal="form-update-document" title="Update" id_update="<?php echo $row['document_id']?>"><span class="glyphicon glyphicon-edit"></span> </button>
                  <button class="btn btn-default btn-xs document-delete-btn-<?php echo $row['document_id']?>" modal="delete-document-modal"  
                  id_update="<?php echo $row['document_id']?>" title="Delete"><span class="glyphicon glyphicon-remove"></span> </button></td>
              </tr>
              <script>
                  $(".document-update-btn-<?php echo $row['document_id']?>").click(function(e){
              
                      var type_modal = $(this).attr("modal");
                      get_modal(type_modal,".document-update-btn-<?php echo $row['document_id']?>");
                      
                  });
                  $(".document-delete-btn-<?php echo $row['document_id']?>").click(function(e){
              
                      var type_modal = $(this).attr("modal");
                      get_modal(type_modal,".document-delete-btn-<?php echo $row['document_id']?>");
                      
                  });
              </script>
              </tr>
              <?php
                  }
              ?>
             </tbody>
             
            </table>
            <br />
             <small class="text-muted"> <i class="glyphicon glyphicon-info-sign"></i> &nbsp; The "Number" of the document will be hidden from others . </small>
          </div>
        </div>
    </div>