<div class="modal fade" id="seatizen-delete" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Seatizen delete </h4>
      </div>
      <form id="form-seatizen-delete">
        <div class="modal-body">
          <span class="fds_info"></span>
          <p> Are you sure want to delete this seatizen : <b>"<?=$seatizen["email"]?>"</b> ? </p>
          <input type="hidden" name="id_seatizen" value="<?=$seatizen["pelaut_id"]?>">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onClick="delete_seatizen_process()">Delete </button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
	$(document).ready(function(e) {
    	$("#seatizen-delete").modal({
			"show":true	
		})    
    });
	
	function delete_seatizen_process()
	{
		$.ajax({
			type:"POST",
			data:$("form#form-seatizen-delete").serialize(),
			url:"<?=base_url("seatizen/seatizen_delete_process")?>",
			dataType:"JSON",
			success: function(res)
			{
				$(".fds_info").html(res.message);
			}
			
				
		})	
		
	}
	
	
	
</script>