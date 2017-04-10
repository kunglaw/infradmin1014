<script>
	
	function edit_agentsea(id_perusahaan)
	{
		
		$.ajax({
			type:"POST",
			data:"x=1&id_perusahaan="+id_perusahaan,
			url:"<?=base_url("agentsea/form_edit_agentsea")?>",
			success:function(data){
				
				$("#modal-agentsea").html(data);
				
			}
			
			
		});
		
	}

	function edit_tampil(id){

		$.ajax({
			type:"POST",
			data:"x=1&id_perusahaan="+id,
			url:"<?=base_url('agentsea/edit_tampil');?>",
			success:function(data){
				$("#modal-agentsea").html(data);
			}
		})

	}

	
	function edit_agentsea_aktif(id_perusahaan){

		$.ajax({
			type:"POST",
			data:"x=1&id_perusahaan="+id_perusahaan,
			url:"<?=base_url('agentsea/form_edit_data');?>",
			success:function(data){
				$("#modal-agentsea").html(data);
			}
		})

	}
	
	
	function edit_role(id_perusahaan)
	{
		$.ajax({
			type:"POST",
			data:"x=1&id_perusahaan="+id_perusahaan,
			url:"<?=base_url("agentsea/form_edit_role")?>",
			success:function(data){
				
				$("#modal-agentsea").html(data);
				
			}
			
			
		});
		
	}
	
	function edit_account_type(id_perusahaan)
	{
		$.ajax({
			type:"POST",
			data:"x=1&id_perusahaan="+id_perusahaan,
			url:"<?=base_url("agentsea/edit_account_type")?>",
			success:function(data){
				
				$("#modal-agentsea").html(data);
				
			}
			
			
		});	
		
	}
	
	function edit_account_setting(id_perusahaan)
	{
		$.ajax({
			type:"POST",
			data:"x=1&id_perusahaan="+id_perusahaan,
			url:"<?=base_url("agentsea/edit_account_setting")?>",
			success:function(data){
				
				$("#modal-agentsea").html(data);
				
			}
			
			
		});	
		
	}
	
	function edit_official(id_perusahaan)
	{
		$.ajax({
			
			type:"POST",
			data:"x=1&id_perusahaan="+id_perusahaan,
			url:"<?=base_url("agentsea/edit_official")?>",
			error:function(err)
			{
				alert(err.toSource());
			},
			success:function(data){
				
				$("#modal-agentsea").html(data);
				
			}
			
			
		});
			
	}

</script>