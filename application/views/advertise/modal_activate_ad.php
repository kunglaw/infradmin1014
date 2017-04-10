<div class="modal fade" id="activate-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    	
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"> Activate Ad </h4>
        </div>
        
        <form role="form" id="activate-modal-form">
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
             <label>status</label>
             <select name="status" id="status" class="form-control">
             	<?php
					$selected_on = "";
					$selected_off = "";
					
					if($order["status"] == "on")
					{
						$selected_on = "selected=selected";
						$selected_off = "";
					}
					else
					{
						$selected_on = "";
						$selected_off = "selected=selected";	
					}
				
				?>
             	<option value="off" <?=$selected_off?>> Off </option>
                <option value="on" <?=$selected_on?>> On </option>
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

		$("#activate-modal").modal({
			show:true,
			backdrop:"static"	
		});
		
    });
	
	$("#activate-modal-form").submit(function(){
		
		// check paid_status
		$.ajax({
			type:"POST",
			data:$("form#activate-modal-form").serialize(),
			url:"<?=base_url("advertise/activate_process")?>",
			dataType:"JSON",
			success: function(data)
			{
				$(".info-activate-modal").html(data.message);		
			}
			
		});
	
		return false;
	});
	

</script>