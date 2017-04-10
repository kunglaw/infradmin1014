<div class="modal fade" id="paid-status-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    	
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"> Change paid Status </h4>
        </div>
        
        <form role="form" id="paid-status-form">
          <div class="modal-body">
          	<div class="info-activate-modal"></div>
          
          	<input type="hidden" name="id_ad" id="id_ad" value="<?=$order["id_ad"]?>">
          	
            <div class="form-group">
            	<label> No. Invoice </label>
            	<input type="text" name="no_invoice" id="no_invoice" value="<?=$order["id_ad"]?>" class="form-control" disabled>
            </div>
            
            <div class="form-group">
            	<label> Ad Name </label>
                <input type="text" name="ad_name" id="ad_name" value="<?=$order["ad_name"]?>" class="form-control" disabled>
            </div>
            
            <div class="form-group">
             <label>Paid status</label>
             <select name="paid_status" id="paid_status" class="form-control">
             	<?php
					$selected_pc = "";
					$selected_c = "";
					
					if($order["paid_status"] == "pending_confirm")
					{
						$selected_pc = "selected=selected";
						$selected_c = "";
					}
					else
					{
						$selected_pc = "";
						$selected_c = "selected=selected";	
					}
				
				?>
             	<option value="pending_confirm" <?=$selected_pc?>> Pending Confirm </option>
                <option value="confirm" <?=$selected_c?>> Confirm </option>
             </select>
            </div>
             
          </div>
          
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="Activate">Save changes</button>
          </div>
        </form>
        
    </div>
  </div>
</div>

<script>
	
	$(document).ready(function(e) {

		$("#paid-status-modal").modal({
			show:true,
			backdrop:"static"	
		});
		
    });
	
	$("#paid-status-modal").submit(function(){
		
		// check paid_status
		$.ajax({
			type:"POST",
			data:$("form#paid-status-form").serialize(),
			url:"<?=base_url("advertise/paid_status_process")?>",
			dataType:"JSON",
			success: function(data)
			{
				$(".info-activate-modal").html(data.message);		
			}
			
		});
	
		return false;
	});
	

</script>