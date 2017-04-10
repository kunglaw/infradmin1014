<?php $profile = $resume['profile']?>

<div class="modal fade modal-resume" id="modal-seaman" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md"><!-- large -->
    <div class="modal-content"> 
        <div class="modal-header bg-primary" style="padding:-20px 0 -20px 0">
            <h4> Edit Profile <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></h4> 
        </div><!-- modal-header -->
        <div class="modal-body">
        	
			<script>
                function submit_kepelautan()
				{
					
					$.ajax({
						
						type:"POST",
						url:"<?php echo base_url("seatizen/edit_kepelautan_process"); ?>",
						data:$("#form-edit-kepelautan").serialize(),
						dataType:"JSON",
						success:function(data){
							
							$("#tampung_error").html(data.message);
							
							if(data.type == "success")
							{
								setTimeout(function() {
									location.reload();
								}, 3000);
							};
						}
						
					});
					
				}	
				
			</script>
            <div id="tampung_error"></div>
            <form id="form-edit-kepelautan" role="form" method="post">
              
              <div class="" style="margin:0 0 0 0;">
              	  <input type="hidden" value="<?=$profile["pelaut_id"]?>" name="pelaut_id" id="pelaut_id" >
                   <div class="form-group" style="width:80%">
                    <label for="vessel_type">
                       Vessel Type                   	
                    </label>
                    <select class="form-control" name="vessel_type">
                    <?php
                        foreach($vessel_type as $row){
							
                            $svt = "";
                            if($row['type_id'] == $profile['vessel_type'] )
                            {
                              $svt = "selected='selected'";  
                            }
                            
                    ?>
                        <option value="<?php echo $row['type_id']; ?>" <?php echo $svt; ?> ><?php echo $row['ship_type']; ?></option>
                    <?php
                        }
                    ?>
                    </select>
                  </div>
                  
                  <div class="form-group" style="width:80%">
                    <label for="department">
                        Department                    	
                    </label>
                    <select class="form-control" name="department" id="department">
                    	<option value="" <?php if(empty($profile['department'])){ echo "selected=selected"; }else{ echo ""; } ?>>
                        - Select Department -</option>
                    <?php
                        foreach($department as $row){
                            
                            $sd  = "";
                            if($profile['department'] == $row['department_id'])
                            {
                                $sd = "selected='selected'";
                            }
                    ?>
                        <option value="<?php echo $row['department_id']; ?>" <?php echo $sd ?>><?php echo $row['department']; ?></option>
                    <?php
                        }
                    ?>
                    </select>
                    <script>
                      $("#department").change(function(e)
                      { 
                          var department_id = $(this).val(); 
                          get_coc_class(department_id,"<?=$profile['coc_class']?>");
                          get_rank(department_id,"<?=$profile['rank']?>"); 
                          
                      });
                      
                     
					 function get_coc_class(department_id,id_coc_class)
					  {
                          $.ajax({
                              
                              type:"POST",
                              url:"<?php echo base_url("seatizen/get_coc_class"); ?>",
                              data:"department_id="+department_id+"&id_coc_class="+id_coc_class,
                              success: function(data)
                              {
                                  $("#coc_class").html(data);
                              }
                              
                          });
                      }
                      
                    </script>
                  </div>
                  
                  <div class="form-group" style="width:80%">
                    <label for="coc_class">
                        COC Class                    	
                    </label>
                    <select class="form-control" name="coc_class" id="coc_class">
                    <?php
                        
                        foreach($coc_class as $row){
                          $scc = "";
                          if($profile['coc_class'] == $row['id_coc_class'])
                          {
                              $scc = "selected='selected'";	
                          }
                    ?>
                          
                        <option value="<?php echo $row['id_coc_class']; ?>" <?php echo $scc ?> ><?php echo $row['coc_class']; ?></option>
                    <?php
                          
                        }
                    ?>
                    </select>
                    <script>
                      
                      
                      
                    
                    </script>
                  </div>
                  
                  <div class="form-group" style="width:80%">
                    <label for="rank">
                       Rank                 	
                    </label>
                    <select class="form-control" name="rank" id="rank">
                   
                    <?php
                       
                        foreach($rank as $row){
                             $sr = "";
                            if($row['rank_id'] == $profile['rank'] ){
                              $sr = "selected='selected'";  
                            }
                    ?>
                        <option value="<?php echo $row['rank_id']; ?>" <?php echo $sr ?>><?php echo $row['rank']; ?></option>
                    <?php
                        }
                    ?>
                    </select>
                     <script>
                      
                      function get_rank(department_id,id_rank)
                      {
                          $.ajax({
                              
                              type:"POST",
                              url:"<?php echo base_url("seatizen/get_rank"); ?>",
                              data:"department_id="+department_id+"&id_rank="+id_rank,
                              success: function(data)
                              {
                                  $("#rank").html(data);
                              }
                              
                          });
                      }
                      
                    </script>
                  </div>
                  
                  <div class="form-group" style="width:80%">
                      <label for="last_education">Last Education</label>
                       <input type="text" name="last_education" id="last_education" value="<?php echo $profile['last_education'] ?>" class="form-control">
                  
                  </div>
                  
                  <div class="form-group" style="width:80%">
                      <label for="last_education" class="row container">Expected Sallary</label>
                      
                      <div class="" style="">
                        <div class="pull-left" style="width:25%">
                          
                          <select name="exp_sallary_curr" id="exp_sallary_curr" class="form-control">
                              <?php
                                $selected_dollar = "";
                                $selected_euro = "";
                                $selected_rp = "";
                                $selected_sgd = "";
                                
                                if($profile['exp_sallary_curr'] == "USD")
                                {
                                  $selected_dollar = "selected='selected'"; 
                                }
                                else if($profile['exp_sallary_curr'] == "EURO")
                                {
                                   $selected_euro = "selected='selected'"; 
                                }
                                else if($profile['exp_sallary_curr'] == "IDR")
                                {
                                   $selected_rp = "selected='selected'"; 
                                }
                                else if($profile['exp_sallary_curr'] == "SGD")
                                {
                                   $selected_sgd = "selected='selected'"; 
                                }
                              ?>
                           
                              <option value="USD" <?php echo $selected_dollar ?> >USD</option>
                              <option value="EURO" <?php echo $selected_euro ?> >EURO</option>
                              <option value="IDR" <?php echo $selected_rp ?> >IDR</option>
                              <option value="SGD" <?php echo $selected_sgd ?> >SGD</option>
                         
                          
                          </select>
                        </div>
                        <div class=" pull-left"  style="width:40%">
                            <input type="text" name="expected_sallary" id="expected_sallary" class="form-control" value="<?php echo $profile['expected_sallary'] ?>" placeholder="sallary..." />
                        </div>
                        <div class="pull-left" style="width:35%">
                          <select name="sallary_range" id="sallary_range" class="form-control">
                            <?php
                              $selected_day 		= "";
                              $selected_month 	  = "";
                              $selected_year	   = "";
                              
                              if($profile['sallary_range'] == "day")
                              {
                                  $selected_day 		= "selected='selected'";
                              }
                              else if($profile['sallary_range'] == "month")
                              {
                                  $selected_month 		= "selected='selected'";
                              }
                              else if($profile['sallary_range'] == "year")
                              {
                                  $selected_year 		= "selected='selected'";
                              }
                            
                            ?>
                            <option value="day" <?=$selected_day?> >/ Day</option>
                            <option value="month" <?=$selected_month?> >/ Month</option>
                            <option value="year" <?=$selected_year?> >/ Year</option>
                        
                          </select>
                        </div>
                        
                        <span class="clearfix"></span>
                        
                      </div>
                  </div>
                  
                  <div class="form-group">
                  		<button class="btn btn-success" type="button" id="save-kepelautan-btn"><span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;Save </button>
                <button class="btn btn-primary" data-dismiss="modal"><span class="glyphicon glyphicon-remove-circle"></span>&nbsp; Cancel </button>
                  </div>
                  
              </div>
			</form>   
        </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	
	$(document).ready(function(e) {
        
		var department_id = $("#department").val(); 
		get_coc_class(department_id,"<?=$profile['coc_class']?>");
        get_rank(department_id,"<?=$profile['rank']?>"); 
		
		$("#modal-seaman").modal({
			backdrop:"static",
			show:true	
		});
		
		$("#save-kepelautan-btn").click(function(){
					
			submit_kepelautan();
		});
    });
	

</script>


