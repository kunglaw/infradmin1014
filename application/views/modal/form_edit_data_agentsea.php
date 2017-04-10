<!-- <script src="<?php echo asset_url("plugin/ms-dropdown-master/js/msdropdown/jquery.dd.min.js")?>"></script> -->
<!-- <link rel="stylesheet" type="text/css" href="<?php echo asset_url("plugin/ms-dropdown-master/css/msdropdown/dd.css"); ?>" /> -->

<div class="modal fade " id="form_edit_agentsea_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    
      <form method="post" action="<?=base_url("agentsea/proses_edit_agentsea")?>" role="form" id="formid" >
        <div class="modal-header bg-header-modal">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          
          <h4 class="modal-title"><?=$agentsea['nama_perusahaan']?> - Edit</h4>
          
        </div>
        <div class="modal-body">
		  <span class="info-response"></span>
          <div id="hasilnya"></div>
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
        
          
            <div class="col-md-4 pull-left">
              
              <div class="form-group">
                <label> Username </label>
                <input type="text" class="form-control" name="username" value="<?=$agentsea['username']?>" readonly style="width:90%" />
              </div> 
              
              <div class="form-group">
                  <label for="nama_perusahaan" style="display:block">Company Name </label>
                  <input type="text" value="<?=$agentsea['nama_perusahaan']?>" name="nama_perusahaan" id="nama_perusahaan" class="form-control" style="width:90%">
              </div>
              
              
              
              <?php
				$nationality = $this->nation_model->get_nationality();
				
			  ?>
              <div class="form-group">
              	  <label for="nationality">Nationality</label>
                  <select name="nationality" id="nationality" class="form-control" style="width:90%">
                    	<?php foreach($nationality as $row){ ?>
                        <?php 
							if($agentsea['id_nationality'] == $row['id'])
							{
								$selected = "selected=selected";	
							}
							else
							{
								$selected = "";	
							}
						
						?>
                    	<option value="<?=$row['id']?>" <?=$selected?> >
                        	<?=$row['name']?>
                        </option>
                        <?php } ?>
                  </select>
              </div>
              
              <div class="form-group">
                  <label for="" style="display:block">Contact Person </label>
                  <input type="text" value="<?=$agentsea['contact_person']?>" name="contact_person" id="contact_person" class="form-control" style="width:90%" >
              </div>
              <div class="form-group">
                  <label for="" style="display:block">Website</label>
                  <input type="text" value="<?=$agentsea['website']?>" name="website" id="website" class="form-control" style="width:90%">
              </div>
              
              <div class="form-group">
                  <label for="" style="display:block">Phone Number </label>
                  <input type="text" value="<?=$agentsea['no_telp']?>" name="no_telp" id="no_telp" class="form-control" style="width:90%">
              </div>
              
            </div>
            <div class="col-md-4 pull-left">
              
              
              <div class="form-group">
                  <label for="" style="display:block">Fax </label>
                  <input type="text" value="<?=$agentsea['fax']?>" name="fax" id="fax" class="form-control" style="width:90%">
              </div>
              <div class="form-group">
                  <label for="" style="display:block">Email </label>
                  <input type="text" value="<?=$agentsea['email']?>" name="email" id="email" class="form-control" style="width:90%">
              </div>
              <div class="form-group">
                  <label for="" style="display:block">Address </label>
                  <input type="text" value="<?=$agentsea['address']?>" name="address" id="address" class="form-control" style="width:90%">
              </div>
              <div class="form-group">
                  <label for="" style="display:block">Visi </label>
                  <input type="text" value="<?=$agentsea['visi']?>" name="visi" id="visi" class="form-control" style="width:90%">
              </div>
              
              <div class="form-group">
                  <label for="" style="display:block">Misi </label>
                  <input type="text" value="<?=$agentsea['misi']?>" name="misi" id="misi" class="form-control" style="width:90%">
              </div>

            </div>
           
           <div class="clearfix"></div>
          
           <div class="col-md-10">
                  <label for="" style="display:block">Description </label>
                  <textarea name="description" id="description" class="form-control"><?=$agentsea['description']?></textarea>
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
	
	
	$("#save-change").click(function(){
		
		$.ajax({
			type:"POST",
			//url:"<?=base_url("agentsea/edit_agentsea_process")?>",
			url:$("#formid").attr("action"),
			//contentType: 'application/html; charset=utf-8',
			data:$("#formid").serialize(),
			beforeSend: function()
			{
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
				
				$("#hasilnya").html(dt);
				
				//alert(dt.state);
				//alert(dt.status+" - "+dt.notification+" - "+dt.error);
				//$(".info-response").html(dt.status+" - "+dt.notification+" - "+dt.error);
				//$(".info-response").html(dt);
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