<div class="modal fade " id="form_edit_agentsea_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    
      <form method="post" action="" role="form" id="form-role" >
        <div class="modal-header bg-header-modal">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          
          <h4 class="modal-title"><?=$agentsea['nama_perusahaan']?> - Change Role</h4>
          
        </div>
        <div class="modal-body">
          <?php //print_r($agentsea); ?>
          
          <data></data>
          
          <input value="<?=$agentsea['id_perusahaan']?>" name="id_perusahaan" id="id_perusahaan" type="hidden">
          <div class="col-md-5">
           <h4> Role </h4>
            <div class="form-group">
              <select name="role" id="role" class="form-control" style="width:90%">
              	<?php
				if($agentsea['role'] == "manager")
				{
					$selected_manager = "selected=selected";	
				}
				else
				{
					$selected_agent = "selected=selected";	
				}
				?>
              	<option value="manager" <?=$selected_manager?> >Manager</option>
                <option value="agent" <?=$selected_agent?> >Agent</option>
              </select>
            </div>
            
            <div class="temp-manager">
            
            </div>
            
          </div>
          <div class="clearfix"></div>
          <hr>
          <div class="col-md-5 pull-left">
            <div class="form-group">
            	<label for="">Username</label>
                <input type="text" class="form-control" value="<?=$agentsea['username']?>" disabled>
            </div>
            
            <div class="form-group">
            	<label for="">Contact Person</label>
                <input type="text" class="form-control" value="<?=$agentsea['contact_person']?>" disabled>
            </div>
          </div>
          <div class="col-md-5 pull-left">
          	<div class="form-group">
            	<label for="">Email</label>
                <input type="text" class="form-control" value="<?=$agentsea['email']?>" disabled>
            </div>
            <div class="form-group">
            	<label for="">Website</label>
                <input type="text" class="form-control" value="<?=$agentsea['website']?>" disabled>
            </div>
          </div>
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

function list_manager()
{
	$.ajax({
		type:"POST",
		data:"x=1&id_perusahaan=<?=$agentsea['id_perusahaan']?>",
		url:"<?=base_url("agentsea/ajax_manager")?>",
		//contentType:"application/json",
		//dataType:"application/json",
		error: function(dt)
		{
			alert(dt.error);
		},
		success: function(dt){
			 
			 dtt = JSON.parse(dt);
			 //$("data").append(dtt[0].nama_perusahaan);
			 
			 $("<label for='manager'> Manager Agentsea </label>").appendTo(".temp-manager");
			 $("<select name='manager' class='form-control'> </select>").appendTo(".temp-manager");
			 for (var i = 0; i < dt.length; i++) {
				 
				  //var selecti  = "<select name='manager' > ";
				  var optionsi = "<option value='"+dtt[i].id_perusahaan+"'>"+dtt[i].id_perusahaan+" - "+dtt[i].nama_perusahaan+"</option>";
				  //var selectn  = "</select>";
				  
				  //alert(dt[i]);
				  
				  $(optionsi).appendTo('.temp-manager select');
			 }
			  
			  //alert(dt);
			
		}	
		
	})
	
}

function submit_role()
{
	$.ajax({
		type:"POST",
		data:$("#form-role").serialize(),
		url:"<?=base_url("agentsea/edit_role_process")?>",
		error:function(dt)
		{
			alert(dt.responseText);	
		},
		success: function(dt){
			
			//alert(dt);
			$("data").html(dt);
			
		}
		
	});	
	
}

function clear_manager()
{
	$(".temp-manager").html("");	
}


$(document).ready(function(e) {
    $('#form_edit_agentsea_modal').modal({
	  show:true,
	  backdrop:"static"
	});
	
	$("#role").change(function(){
		if($(this).val() == "manager")
		{
			clear_manager();
		}
		else
		{
			list_manager();
		}
		
	});
	
	$("#save-change").click(function(){
		
		submit_role();
				
	});
		
	/* $("form #ext_num").msDropDown();
	$("form #nationality").msDropDown();
	$("form #nama_perusahaan_select").msDropDown();*/
});


</script>