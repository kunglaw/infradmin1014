<?php $profile = $resume['profile']; 
	  $pelaut  = $resume['pelaut'];
?>

<div class="modal fade modal-resume" id="modal-profile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index: 10000;">
  <div class="modal-dialog modal-lg"><!-- large -->
    <div class="modal-content"> 
        <div class="modal-header bg-primary" style="padding:-20px 0 -20px 0">
            <h4> Edit Profile
            
            <?php if(!empty($pelaut["gender"])){?>
            <button type="button" class="close" id="close-modal-btn" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <?php } ?>
            
            
            
            </h4>
        </div><!-- modal-header -->
        <div class="modal-body">
          <div id="form-profile">
          	
            <script>
			
				function submit_profile()
				{
					//var data = $("#form-edit-profile").serialize();
					//alert(data);
					$.ajax({
						
						type:"POST",
						url:"<?php echo base_url("seaman/resume_process/edit_profile_process"); ?>",
						data:$("#form-edit-profile").serialize(),
						success:function(data){
							
							$("#tampung_error").html(data);
							
							
							
							;
						},error:function(ts){
						  alert(ts.responseText);
						}
									
					});
					
				}
			  </script>
              <div id="tampung_error"></div>
 				<form role="form" id="form-edit-profile" method="post" >
                <div class="pull-left" style="width:30%">
                    <div class="form-group">
                    <label for="nama_depan">
                      First Name
                    </label>
                    <input type="text" name="nama_depan" id="nama_depan" class="form-control" value="<?php echo $pelaut['nama_depan']; ?>">
                    </div>
                    
                    <div class="form-group">
                      <label for="nama_belakang">
                        Last Name
                      </label>
                    <input type="text" name="nama_belakang" id="nama_belakang" class="form-control" value="<?php echo $pelaut['nama_belakang'] ?>">
                    </div>
                    
                    <div class="form-group">
                    <label for="gender">
                      Gender 
                    </label>
                    <div>
                    <?php
					
                      if($pelaut['gender'] == "female")
                      {
                          $selected_female = "checked=true";
                          $selected_male = "";
                      }
                      else if($pelaut['gender'] == "male")
                      {
                          $selected_female = "";
                          $selected_male = "checked=true";
                          
                      }
					  
                    
                    ?>
                    <label for="gender_male" class="radio-inline"><input type="radio" name="gender" id="gender_male" value="male" 
					<?php echo $selected_male ?>> Male</label>&nbsp;
                    <label for="gender_female" class="radio-inline"><input type="radio" name="gender" id="gender_female" value="female" 
					<?php echo $selected_female ?>> Female</label>
                    </div>
                    </div>
                    
                    
                  <?php /*  <div class="form-group">
                    <label for="email">
                      Email
                    </label>
                    <input type="email" name="email" id="email" value="" class="form-control">
                    </div> */ ?>
                    
                    <div class="form-group col-md-6">
                    <label for="clothes_size" class="">
                        Clothes Size
                    </label>
                    <input type="text" name="clothes_size" id="clothes_size" value="<?php echo $profile['clothes_size'] ?>" class="col-md-12">
                    
                    </div>
                    
                    <div class="form-group col-md-6">
                    <label for="shoes_size">
                        Shoes Size
                    </label>
                    <input type="text" name="shoes_size" id="shoes_size" value="<?php echo $profile['shoes_size'] ?>" class="col-md-12">
                    </div>

                       <div class="form-group col-md-6">
                    <label for="height" class="">
                        Height
                    </label>
                    <input type="text" name="height" id="height" value="<?php echo $profile['height'] ?>" class="col-md-12">
                    
                    </div>
                    <div class="form-group col-md-6">
                    <label for="weight" class="">
                        Weight
                    </label>
                    <input type="text" name="weight" id="weight" value="<?php echo $profile['weight']; ?>" class="col-md-12">
                    </div>
                
                </div><!-- left-->    
                
                <div class="pull-left" style="margin:0 0 0 20px; width:30%">
                	<div class="form-group">
                    <label for="nationality">
                        Nationality
                    </label>
                    
                    <?php //print_r($profile); ?>
                    <!-- <input type="text" name="nationality" id="nationality" value="<?php echo $pelaut['kebangsaan'] ?>" class="form-control"> -->
                    <select class="form-control" name="nationality" id="nationality">
                    	<?php 
							$select1 = '';
							if(empty($pelaut['kebangsaan']))
							{
								$select1 = "selected='selected'";
								$nation_name = "- Select a country -";
							}
							else
							{
								$nation_name = $pelaut['kebangsaan'];
							}
						?>
                    	<option value="" <?php echo $select1 ?> > <?php echo $nation_name ?> </option>
                    <?php foreach($nation as $row23){ 
                        
                        $select1 = '';
                        if($row23['name'] == $pelaut['kebangsaan'])
                        {
                            $select1 = "selected='selected'";
                        }
                    
                    ?>
                        <option value="<?php echo $row23['name']?>" <?php echo $select1 ?>><?php echo $row23['name']?></option>
                    <?php } ?>
                    </select>
                    </div>
                    
                    <div class="form-group">
                    <label for="kin">
                        Next of kin
                    </label>
                    <input type="text" name="kin" id="kin" value="<?php echo $pelaut['keluarga_terdekat'] ?>" class="form-control">
                    </div>
                    
                    <div class="form-group">
                      <label for="kin">
                        Relationship
                      </label>
                      <input type="text" name="relationship" id="relationship" value="<?php echo $pelaut['hubungan'];?>" class="form-control">

                    </div>

                    <div class="form-group">
                    <label for="marrital_status">
                      Marrital Status
                    </label>
                    <div>
                    <?php
                    
                      if($pelaut['status_perkawinan'] == "married")
                      {
                          $checked_married = "checked=true";
                          $checked_singel = "";
                      }
                      else
                      {
                          $checked_married = "";
                          $checked_singel = "checked=true";
                      }
                    
                    ?>
                    <label for="single"  class="radio-inline">
                    <input type="radio" name="marrital_status" id="single" value="single" <?php echo $checked_singel ?>> &nbsp; <span class=""> Single </span> </label>&nbsp;
                    
                    <label for="married"  class="radio-inline">
                    <input type="radio" name="marrital_status" id="married" value="married" <?php echo $checked_married ?>> &nbsp; <span class=""> Married </span> </label>
                    
                    <span class="clearfix"></span>
                    
                    </div>
                    </div>
                    <div class="form-group">
                    <label for="Religion">
                      Religion
                    </label>
                    <?php
                      /*$islam_select = "";
                      $chatolic_select = "";
                      $protestan_select = "";
                      $buddhisme_select = "";
                      $hindu_select = "";
                      $confucius_select = "";
                      $other_select = "";
                      
                      if($profile['agama'] == "islam")
                          $islam_select = "selected=selected";
                      if($profile['agama'] == "chatolic")
                          $chatolic_select = "selected=selected";
                      if($profile['agama'] == "protestan")
                          $protestan_select = "selected=selected";
                      if($profile['agama'] == "bhuddisme")
                          $bhuddisme_select = "selected=selected";
                      if($profile['agama'] == "hindu")
                          $hindu_select = "selected=selected";
                      if($profile['agama'] == "confucius")
                          $confucius_select = "selected=selected";
                      if($profile['agama'] == "other")
                          $other_select = "selected=selected";
                         */
                      
                    ?>
                    <input type="text" value="<?php echo $pelaut['agama'] ?>" id="agama" name="agama" class="form-control"/>
                    <!-- <select class="form-control" id="agama" name="agama" hidden="true">
                      
                      <option value="islam" <?php echo $islam_select ?>>Islam</option>
                      <option value="chatolic" <?php echo $chatolic_select ?>>Catholic</option>
                      <option value="protestan" <?php echo $protestan_select ?>>Protestan</option>
                      <option value="buddhisme" <?php echo $bhuddisme_select ?>>Buddhisme</option>
                      <option value="hindu" <?php echo $hindu_select ?>>Hindu</option>
                      <option value="confucius" <?php echo $confucius_select ?>>Confusius</option>
                      <option value="other" <?php echo $other_select ?>>other</option>
                    
                    </select> -->
                    </div>
                 
                </div><!-- middle-->     
                           
                <div class="pull-left" style="margin:0 0 0 20px;width:30%">
                	<div class="form-group">
                    <label for="phone">
                      Phone
                    </label>
                    <input type="text" name="phone" id="phone" value="<?php echo $pelaut['telepon'] ?>" class="form-control">
                    </div>
                    <div class="form-group">
                    <label for="handphone">
                      Handphone
                    </label>
                    <input type="text" name="handphone" id="handphone" value="<?php echo $pelaut['handphone'] ?>" class="form-control">
                    </div>
                    
                    <div class="form-group">
                    <label for="place_birth">
                      Place of Birth
                    </label>
                    <input type="text" name="place_birth" id="place_birth" value="<?php echo $pelaut['tempat_lahir'] ?>" class="form-control">
                    </div>
                    
                    <div class="form-group date">
                    <label for="date_birth">
                      Date of Birth
                    </label>
                    <input type="text" name="date_birth" id="date_birth" value="<?php echo $pelaut['tanggal_lahir'] ?>" style="background-color: white" readonly class="form-control">
                    </div>
                </div><!-- right-->                            
                
                
                
                
                
                
                <div class="clearfix"></div>
                <div class="form-group">
                <label for="address">
                  Address
                </label>
                <textarea name="address" id="address" class="form-control"><?php echo $pelaut['alamat'] ?></textarea>
                </div>
                <button class="btn btn-success" type="button" id="save-profile-btn"><span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;Save </button>
                <?php if(!empty($pelaut["gender"])){?>
                <button class="btn btn-primary" data-dismiss="modal"><span class="glyphicon glyphicon-remove-circle"></span>&nbsp; Cancel </button>
                <?php } ?>
                <button class="btn btn-warning pull-right" type="button" onclick="call_report_form()"><span class=""></span>&nbsp;Report Problem </button>
                </form>
            
          </div><!-- form-profile -->
        </div><!-- modal body -->

      </div>
   </div>
  </div>
  
<script type="text/javascript">
	
	$("#date_birth").datepicker({
		dateFormat:"yy-mm-dd",
		changeMonth:true,
		changeYear:true,
		yearRange: "-65:-20", // last hundred years
			
	});
	
	$(document).ready(function(e) {
        $("#modal-profile").modal({
			backdrop:"static",
			show:true	
		});
		
		$("#save-profile-btn").click(function(){
					
			submit_profile();
		});
    });
	
	// Since confModal is essentially a nested modal it's enforceFocus method
	// must be no-op'd or the following error results 
	// "Uncaught RangeError: Maximum call stack size exceeded"
	// But then when the nested modal is hidden we reset modal.enforceFocus
	var enforceModalFocusFn = $.fn.modal.Constructor.prototype.enforceFocus;
	
	$.fn.modal.Constructor.prototype.enforceFocus = function() {};
	
	$confModal.on('hidden', function() {
		$.fn.modal.Constructor.prototype.enforceFocus = enforceModalFocusFn;
	});
	
	$confModal.modal({ backdrop : false });

</script>