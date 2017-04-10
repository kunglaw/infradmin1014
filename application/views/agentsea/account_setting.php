<div class="modal fade " id="form_edit_agentsea_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    
      <form method="post" action="<?=base_url("agentsea/account_setting_process")?>" role="form" id="formid" >
        <div class="modal-header bg-header-modal">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          
          <h4 class="modal-title"><?=$agentsea['nama_perusahaan']?> - Edit</h4>
          
        </div>
        <div class="modal-body">
          
		  <span class="info-response"></span>
          <div id="hasilnyanih"></div>
          <input value="<?=$agentsea['id_perusahaan']?>" name="id_perusahaan" id="id_perusahaan" type="hidden">
          <!-- <div class="col-md-5">
           <h4> Role </h4>
            <div class="form-group">
              <select name="role" class="form-control" style="width:90%">
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
          </div>-->
            <?php 
				//print_r($agentsea);
				?>
            <?php
				
				$authorized_checked = "";
				$unauthorized_checked = "";
				$inv_phone_checked ="";
				$inv_email_checked = "";
				
				$active_checked = "";
				$block_checked  = "";
				
				$valid_email_checked = "";
				$invalid_email_checked = "";
				
				$status = explode("|",$agentsea['status']);
				
		
				if(in_array("unauthorized",$status)){
					$unauthorized_checked = "checked=checked";
				}
				
				if(in_array("invalid_email",$status)){
					$inv_email_checked = "checked=checked";
				}
				
				if(in_array("invalid_phone",$status)){
					$inv_phone_checked = "checked=checked";
				}
				
				if(in_array("VERIFIED",$status)){
					$authorized_checked = "checked=checked";
				}
				
				if($agentsea["activation_code"] == "ACTIVE")
				{
					$active_checked = "checked=checked";	
				}
				if($agentsea["activation_code"] == "BLOCK")
				{
					$block_checked = "checked=checked";
				}
				
				if($agentsea["valid_email"] == "VALID")
				{
					$valid_email_checked = "checked=checked";	
				}
				if($agentsea["valid_email"] == "INVALID")
				{
					$invalid_email_checked = "checked=checked";
				}
				
			?>
             
             <div class="container">
             	
             	<?php 
				// kalau officialnya alpha tidak perlu otorisasi
				if($agentsea["official"] == "Agent"){ ?>
                
                <label for=""> Authorization </label>
                <div class="clearfix"></div>  
                <div class="col-md-8">
                	<p> * Authorization is setting an Agentsea to publish their vacantsea. every Agentsea register to informasea is set to "Hold" status which mean Agentsea can't publish their vacantsea that posted </p>
                    <p> if you are set to "Authorized" , all vacantsea an Agentsea that posted before, automatically Publish. Next Agentsea can Post vacantsea, and Publish their vacantsea automatically </p> 
                    <p> if you are set "Unauthorized" and "invalid Phone" the Agentsea still Login and posted a vacantsea but cant publish their vacantsea </p>
                </div>
                <div class="clearfix"></div>  
                <div class="form-group pull-left col-md-2">
                  <input type="radio" name="authorized" id="authorized" <?=$authorized_checked?> class="otorisasi" /> 
                  <label for="authorized"> Authorized </label>
                </div>
                <div class="form-group pull-left col-md-2">
                  <input type="checkbox" name="unauthorized" id="unauthorized" <?=$unauthorized_checked?> title="" class="otorisasi" />
                  <label for="unauthorized">  Unauthorized </label>
                </div>
                <div class="form-group pull-left col-md-2">
                    <input type="checkbox" name="invalid_phone" id="invalid_phone" <?=$inv_phone_checked?>  class="otorisasi" /> 
                    <label for="invalid_phone"> Invalid Phone </label>
                </div>
                <!-- <div class="form-group pull-left col-md-2">
                    <input type="checkbox" name="invalid_email" id="invalid_email" <?=$inv_email_checked?> /> 
                    <label for="invalid_email"> Invalid Email  </label>
                </div>   -->
                
                <div class="clearfix"></div> 
                <?php } ?>
                
                <div class="form-group">
                    <label> Activation </label>
                    <div class="clearfix"></div>  
                    <div class="col-md-8"> * This will set the Agentsea able to login or not. 
                    if you are set to ACTIVE the company be able to Login. 
                    if BLOCKED, the company disabled to Login and Company account and their vacantsea can't be viewed in informasea.com</div>
                    <div class="clearfix"></div>   
                    <div class="form-group pull-left col-md-2">
                      <label for="active">
                          <input type="radio" name="activation" value="ACTIVE" id="active" <?=$active_checked?> > ACTIVE 
                      </label>
                    </div>
                    <div class="form-group pull-left col-md-2">
                      <label for="block">
                          <input type="radio" name="activation" value="BLOCK" id="block" <?=$block_checked?> > BLOCK
                      </label>
                    </div>
                </div>
                <div class="clearfix"></div> 
                
                <div class="form-group">
                <label> Valid Email </label>
                    <br>
                    <div class="form-group pull-left col-md-2">
                      <label for="valid">
                          <input type="radio" name="valid_email" value="VALID" id="valid" <?=$valid_email_checked?> > VALID 
                      </label>
                    </div>
                    <div class="form-group pull-left col-md-2">
                      <label for="invalid">
                          <input type="radio" name="valid_email" value="INVALID" id="invalid" <?=$invalid_email_checked?> > INVALID
                      </label>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group">
                	<label> Send Email </label>
                    <div class="text-mute"> * This action will send an email for Agentsea or not </div>
                	<div class="form-group pull-left col-md-2">
                      <label for="send_email">
                          <input type="checkbox" name="send_email" id="send_email" value="yes" > YES 
                      </label>
                    </div>
                    
                </div>

                <div class="clearfix"></div> 
                
                <span class="small text-muted">* Please be careful, This action will be send an email to corporate webmail system </span>
                
            </div>
            <div class="clearfix"></div>
           
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success" id="save-change">Save changes</button>
        </div>
      </form>
      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<style>
	.box-dashb{
		border:1px solid #00F;
		border-radius:5px 5px 5px 5px;	
	}

</style>


<script>
$(document).ready(function(e) {
    $('#form_edit_agentsea_modal').modal({
	  show:true,
	  backdrop:"static"
	});
	
	$("input[type=radio].otorisasi").click(function()
	{
		$("input[type=checkbox].otorisasi").attr("checked",false);
	});
	
	$("input[type=checkbox].otorisasi").click(function()
	{
		$("input[type=radio].otorisasi").attr("checked",false);
	});
	
	$("#save-change").click(function(){
		
		$.ajax({
			type:"POST",
			//url:"<?=base_url("agentsea/edit_agentsea_process")?>",
			url:$("#formid").attr("action"),
			//contentType: 'application/html; charset=utf-8',
			data:$("#formid").serialize(),
			beforeSend: function()
			{
				//alert($("#formid").serialize());
				var c = confirm("are you sure to update this data ? ");
				
				if(c == false)
				{
				 	return false;	
				}
			},
			success: function(dt){
				/* for (var key in dt) {
				  if (dt.hasOwnProperty(key)) {
						//alert(key);
				  }
				}*/
					$("#hasilnyanih").html(dt);
				//alert(dt);
				
				//alert(dt.state);
				//alert(dt.status+" - "+dt.notification+" - "+dt.error);
				// $(".info-response").html(dt.status+" - "+dt.notification+" - "+dt.error);
				// $(".info-response").html(dt);
			}
			
		});
		
	})
	
	$('input[type=radio]#unauthorized').change(function() {
		if($(this).is(':checked')) {
		
			$(".unauthorized-box").show();
		} 
	});
	$('input[type=radio]#authorized').change(function() {
		if($(this).is(':checked')) {
			
			$(".unauthorized-box").hide();
		} 
	});
	/* $("form #ext_num").msDropDown();
	$("form #nationality").msDropDown();
	$("form #nama_perusahaan_select").msDropDown();*/
});


</script>