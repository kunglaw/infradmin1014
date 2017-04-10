<div id="change-status" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Change Payment Status</h4>
      </div>
      <form id="form-change-status">
      <div class="modal-body">
      	<span id="info-change-status"></span>
       
      	<p> Before you changes this payment status , MAKE SURE the company has already paid the purchase.  </p>
     	<p> Are you sure want to change this Company Payment status ? </p>
         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" >Close</button>
        <button type="button" class="btn btn-primary" onClick="change_status_process('<?=$order['no_invoice']?>')">YES, This company has already paid </button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
	$('#change-status').modal({
	  show:true,
	  backdrop:"static"
	});
	
	function change_status_process(no_invoice='')
	{
		$.ajax({
			type:"POST",
			url:"<?=base_url("request_upgrade/change_status_order")?>",
			data:"no_invoice="+no_invoice,
			error: function(err)
			{
			
			},
			success:function(res)
			{
				$("#info-change-status").html(res);
				setInterval(function(){
					
					location.reload();
					
				},2000)
				
			}
			
			
		});
		
	}
	
</script>