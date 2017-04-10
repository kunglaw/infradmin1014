<div id="change-account" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Change Account Status</h4>
      </div>
      <form id="form-change-account">
      <div class="modal-body">
      	<span id="info-change-account"></span>
       
      	
     	<p> Are you sure want to change this Company Account ? </p>
         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" >Close</button>
        <button type="button" class="btn btn-primary" onClick="change_account_process('<?=$order['no_invoice']?>')">YES, This company has already paid </button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
	$('#change-account').modal({
	  show:true,
	  backdrop:"static"
	});
	
	function change_account_process(no_invoice='')
	{
		$.ajax({
			type:"POST",
			url:"<?=base_url("request_upgrade/change_account_process")?>",
			data:"no_invoice="+no_invoice,
			error: function(err)
			{
				alert("error = "+err.toSource());
			},
			success:function(res)
			{
				alert(res);
				$("#info-change-account").html(res);
				
			}
			
			
		});
		
	}
	
</script>