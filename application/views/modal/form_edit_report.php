
<div class="modal fade " id="form_edit_report_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    
      <form method="post" action="<?=base_url("agentsea/edit_agentsea_process")?>" role="form" id="formid" >
        <div class="modal-header bg-header-modal">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          
          <h4 class="modal-title">Report </h4>
          
        </div>
        <div class="modal-body">
		  
		PIC <?php 
		$str = "SELECT * FROM admin_user";
		$q = $this->db->query($str);
		$f = $q->result_array();
		?>

		<select> 
			<?php 
		foreach($f as $row) { 
			echo "<option>".$row['name']."</option>";
		}
		?>
	</select>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success" id="save-change">Save changes</button>
        </div>
      </form>
      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<style>
	.box-dashb{
		border:1px solid #00F;
		border-radius:5px 5px 5px 5px;	
	}

</style>

