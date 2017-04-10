<script>
	
	function edit_pic(id_report)
	{
		
		$.ajax({
			type:"POST",
			data:"x=1&id_report="+id_report,
			url:"<?=base_url("report_problem/form_edit_pic")?>",
			success:function(data){
				$(".modal-edit-pic").html(data);
				
			}
			
			
		});
		
	}


</script>