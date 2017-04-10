<div class="modal fade" id="modal-delete-email" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                Delete Confirmation
                <div id="hasilnya"> </div>
            </div>

            <div class="modal-body">
                Are you sure you want to Delete this email with subject : "<?=$dt["subject"]?>"  ?
            </div>

            <div class="modal-footer">
                <button type="button" class="button-green-white"
                        id="block-button" onclick="delete_process('<?php echo $dt['id'] ?>')"> Delete </button>

                <button type="button" class="button-green-white"
                        data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
	
	$('#modal-delete-email').modal({
        show:true,
        backdrop:"static"
    });
	
	function delete_process(id)
	{
		$.ajax({
			type:"POST",
			data:"id="+id,
			url:"<?=base_url("send_email/delete_process")?>",
			success: function(dt)
			{
				setTimeout(function(){ 
					location.reload();
				},200);
				
			}
			
		});
			
	}
	
</script>