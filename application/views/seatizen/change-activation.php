<div class="modal fade " id="form_change_activation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    
      <form method="post" action="" role="form" id="form-change-activation" >
        <div class="modal-header bg-header-modal">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          
          <h4 class="modal-title"> Change Activation </h4>
          
        </div>
        <div class="modal-body">
          <div class="result-change-activation"></div>
          <input type="hidden" name="pelaut_id" id="pelaut_id" value="<?=$seatizen["pelaut_id"]?>">
           Are you sure you want to Activate this seaman ? 
          
          <div class="clearfix"></div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="save-change">Save changes</button>
        </div>
      </form>
      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>

function submit_change_activation()
{
	$.ajax({
		type:"POST",
		data:$("#form-change-activation").serialize(),
		dataType:"JSON",
		url:"<?=base_url("seatizen/change_activation_process")?>",
		success: function(data){
			
			$(".result-change-activation").html(data.message);
			
		}
		
	}); 
	
}


$(document).ready(function(e) {
    $('#form_change_activation').modal({
		
		show:true,
		backdrop:"static"
		
	});
	
	$("#save-change").click(function(){
		
		submit_change_activation();
		return false;
				
	});
	
});


</script>