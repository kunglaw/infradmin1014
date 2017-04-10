<div class="modal fade" id="vacantsea-delete" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Vacantsea delete </h4>
      </div>
      <form id="form-vacantsea-delete">
        <div class="modal-body">
          <span class="fds_info"></span>
          <p> Are you sure want to delete this Vacantsea : <b>"<?=$vacantsea["vacantsea"]?>"</b> ? </p>
          <input type="hidden" name="id_vacantsea" value="<?=$vacantsea["vacantsea_id"]?>">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onClick="delete_vacantsea_process()">Delete </button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
	$(document).ready(function(e) {
    	$("#vacantsea-delete").modal({
			"show":true	
		})    
    });
	
	function delete_vacantsea_process()
	{
		$.ajax({
			type:"POST",
			data:$("form#form-vacantsea-delete").serialize(),
			url:"<?=base_url("vacantsea/vacantsea_delete_process")?>",
			dataType:"JSON",
			success: function(res)
			{
				$(".fds_info").html(res.message);
			}
			
				
		})	
		
	}

</script>