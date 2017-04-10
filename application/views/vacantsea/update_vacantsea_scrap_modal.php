
<script>
$(document).ready(function(e) {
	

	
	$("#get_id_department").change(function(){
				  
	  $.ajax({
		  url:"<?php echo base_url("index.php/rank/rankajax_bydept") ?>",
		  type: "POST",
		  data:"id_department=" + $(this).val(),
		  success: function(data) {
			  
			  $("#get_rank").html(data);
		  }	
	});
	
});

function validasi_salary(){
	
	var salary = document.forms['post_form']['salary'].value;
	var number = /^[0-9]+$/;
	if (!salary.match(number)) {
		alert("Salary harus angka");
		return false;
	};
}

});
</script>

<!-- <script src="<?=asset_url('js/validasi_angka.js');?>"></script> -->
				  
<div id="info"></div>

<style>

.ui-datepicker { width: 17em; padding: .2em .2em 0; z-index:9000 !important;}

</style>

<div class="modal fade modal-form-edit" id="" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="myModalLabel">

 <div class="modal-dialog" style="width:1000px !important">

 <div class="modal-content"> 

    	<div class="modal-header bg-primary" style="padding:-20px 0 -20px 0">

        	<h4> Form Update Scrap Vacantsea <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span></button></h4>

        </div>

    	<div class="modal-body">

        	<script>

				function update_vacantsea_process()
				{

					$.ajax({

						type  : "POST",
						url   : "<?=base_url('vacantsea/update_scrap_vacantsea_process'); ?>",
						data  : $("form#form-update-vacantsea").serialize(),
						dataType:"JSON",
						success: function(data){
							
							if(data.status == "success")
							{
								$(".modal-info").html(data.message);
								window.location.href = "<?=base_url("vacantsea/detail/page/$vacantsea_edit[vacantsea_id]");?>";
							}
							else
							{
								$(".modal-info").html(data.message);
								
							}
                            //
							//alert(data);
						}
					});

				}

				

				$(document).ready(function() {

                    $("#update_button").click(function(){



						update_vacantsea_process();

					});

                });

				</script>

        	

            <div id="info"> </div>

            <div id="form-update-vacantsea">
				<div class="modal-info"></div>
                
            	<form role="form" action="" method="post" id="form-update-vacantsea">

                	<div class="box-body">
						
                        <div>

                            <div class="col-sm-4"> 
                        
                                <div class="form-group">
                        
                                    <label>Company *</label>
                        
                                    <input type="text" value="<?=$company["company"]?>" name="company" id="company_name" class="form-control" autocomplete="off">
                        
                                </div>
                        
                            </div>
                        
                            <div class="col-sm-4">
                        
                                <div class="form-group">
                        
                                    <div class=""> 
                        
                                    <label> Username *</label>
                        
                                    <input type="text" value="<?=$company["username"]?>" name="username" id="username_val" class="form-control username_val" autocomplete="off">
                        
                                    </div>
                        
                                </div>
                        
                            </div>
                        
                            <div class="col-sm-4"> 
                        
                                <div class="form-group">
                        
                                    <label> Contact Person </label>
                        
                                    <input type="text" value="<?=$company["contact_person"]?>" name="contact_person" id="contact_person" class="form-control">
                        
                                </div>
                        
                            </div>
                        
                        </div>
                        <div>   
                        
                            <div class="col-sm-4">
                        
                                <div class="form-group">
                        
                                    <div class=""> 
                        
                                    <label> Website *</label>
                        
                                    <input type="text" value="<?=$company["website"]?>" name="website" id="website_val" class="form-control website_val" autocomplete="off">
                        
                                    </div>
                        
                                </div>
                        
                            </div>  
                        
                            <div class="col-sm-4">
                        
                                <div class="form-group">
                        
                                    <div class=""> 
                        
                                    <label> Email *</label>
                        
                                    <input type="email" value="<?=$company["email"]?>" name="email" id="email_val" class="form-control email_val" autocomplete="off">
                        
                                    </div>
                        
                                </div>
                        
                            </div>
                        
                            <!-- <input type="hidden" value="" name="id" id="id_val"> --> 
                        
                            <div class="col-sm-4">
                        
                                <div class="form-group">
                        
                                    <div class=""> 
                        
                                    <label> No Telp </label>
                        
                                    <input type="no_telp" value="<?=$company["no_telp"]?>" name="no_telp" id="no_telp_val" class="form-control no_telp_val" autocomplete="off">
                        
                                    </div>
                        
                                </div>
                        
                            </div>  
                        
                        </div>
                        <div>
                            <div class="col-sm-4">
                        
                                <div class="form-group">
                        
                                    <div class=""> 
                        
                                    <label> Url Source </label>
                        
                                    <input type="url" value="<?=$company["url_source"]?>" name="url_source" id="url_source" class="form-control " autocomplete="off">
                        
                                    </div>
                        
                                </div>
                        
                            </div>
                        
                        </div>
                        
                        <span class="clearfix"></span>
                        
                        <hr>
                        
                		<div>

                            <div class="col-sm-4">

                                <div class="form-group">

                                    <label>Title</label>

                                    <input type="hidden" name="vacantsea_id" value="<?php echo $vacantsea_edit['vacantsea_id'];?>">
                                    
                                    <input type="text" class="form-control" value="<?php echo $vacantsea_edit['vacantsea'] ?>" id="title" 
                                    name="title" required/>

                                    <input type="hidden" value="<?php echo $vacantsea_edit['vacantsea_id'] ?>" name="vacantsea_id" />
                                </div>

                                <div class="form-group">
                                    <label>Navigation Area</label>
                                    <input type="text" class="form-control" value="<?php echo $vacantsea_edit['navigation_area'] ?>" id="nav_area" name="nav_area"/>
                                </div>

                                <div class="form-group">

                                    <label>Vesel Type</label>
                                    <select class="form-control" name="ship_type" id="ship_type">
                                        <?php
                                            foreach ($type_ship as $row) {

                                                if ($row['type_id'] == $vacantsea_edit['ship_type']) {
                                                    $select     = "selected='selected'";
                                                }else{
                                                    $select     = "";

                                                }

                                                echo "<option value='$row[type_id]' ".$select."> $row[ship_type]</option>";

                                            }

                                        ?>

                                    </select>

                                </div>

                                <div class="form-group">

                                    <label for="departement"> Departement </label>
									
                                    <select class="form-control" id="get_id_department" name="department_id">

                                    <?php 

                                        foreach($department as $row) { 

                                            $dept = "";

                                          if($row['department_id'] == $vacantsea_edit['department'] )
                                          {

                                            $dept = "selected='selected'";  

                                          }

                                    ?>

                                    <option value="<?php echo $row['department_id'] ?>" <?php echo $dept ?>><?php echo $row['department'] ?></option>

                                    <?php } ?>

                                    </select>

                                </div>

                                <div class="form-group">

                                    &nbsp;

                                </div>

                            </div><!-- /.col-sm-4-->


                            <div class="col-sm-4">

                                

                                <div class="form-group">

                                    <label for="rank">Rank</label>

                                    <select class="form-control" name="rank_id" id="get_rank">

                                    <?php 

										foreach($rank as $row) { 

											$r = "";

										  if($row['rank_id'] == $vacantsea_edit['rank_id'] )

										  {

											$r = "selected='selected'";  

										  }

									?>

                                    <option value="<?php echo $row['rank_id'] ?>" <?php echo $r ?>><?php echo $row['rank'] ?></option>

                                    <?php } ?>

                                    </select>

                                </div>

                                

                                <div class="form-group">

                                <label>Salary</label>

                                    <div  class="row">

                                    <div class="col-sm-4">

                                        <select class="form-control" name="salary_curr" id="sallary_curr">

                                            <?php

                                                $sallary_curr   = $vacantsea_edit['sallary_curr'];

                                            ?>

                                            <option value="IDR" <?php if($sallary_curr == "IDR"){ echo "selected"; } ?> >IDR</option>

                                            <option value="SGD" <?php if($sallary_curr == "SGD"){ echo "selected"; } ?> >SGD</option>

                                            <option value="USD" <?php if($sallary_curr == "USD"){ echo "selected"; } ?> >USD</option>

                                            <option value="EUR" <?php if($sallary_curr == "EUR"){ echo "selected"; } ?> >EUR</option>

                                        </select>

                                    </div>

                                    <div class="col-sm-4">

                                    <input type="text" class="form-control" value="<?php echo $vacantsea_edit['annual_sallary'] ?>" id="salary" name="salary"/>

                                    </div>

                                    <div class="col-sm-4" style="margin-bottom:-20px !important">

                                    <select class="form-control" id="sal_type" name="salary_type">

                                        <?php

                                            $sallary_rank   = $vacantsea_edit['sallary_range'];

                                        ?>

                                        <option value="/day" <?php if($sallary_rank == "/day"){ echo "selected"; } ?> >/ Day</option>

                                        <option value="/month" <?php if($sallary_rank == "/month"){ echo "selected"; } ?> >/ Month</option>

                                        <option value="/year" <?php if($sallary_rank == "/year"){ echo "selected"; } ?> >/ Year</option>

                                    </select>

                                    </div>

                                    </div>

                                </div>

                                <div class="form-group">

                                    <label>Contract Dynamics</label>

                                    <input type="text" class="form-control" value="<?php echo $vacantsea_edit['contract_dynamic'] ?>" id="contract_dyn" name="contract_dyn"/>

                                </div>

                                <!-- <div class="form-group">

                                    <label>Benefits</label>

                                    <input type="text" class="form-control" value="<?php echo $vacantsea_edit['benefits'];?>" id="benefits" name="benefits"/>

                                </div> -->

                                <div class="form-group">

                                    <label>Requested Certificate</label>

                                    <input type="text" class="form-control" value="<?php echo $vacantsea_edit['requested_certificates'] ?>" id="req_cert" name="req_cert"/>

                                </div>

                                <div class="form-group">

                                    &nbsp;

                                </div>

                            </div><!-- /.col-sm-4-->

                            

                            

                            <div class="col-sm-4">

                                <div class="form-group">

                                    <label>Requested COC</label>

                                    <input type="text" class="form-control" value="<?php echo $vacantsea_edit['requested_coc'] ?>" id="req_coc" name="req_coc"/>

                                </div>

                                <div class="form-group">

                                    <label> Nationality </label>

                                    <select class="form-control" id="nationality" name="nationality_id">

                                    <?php 
										
										$n = "";
										$ep = "";
										
										if(empty($vacantsea_edit['id_nationality']))
										{
											$ep = "selected = 'selected'";
											
										}
										
										echo  "<option value='' $ep > -- select -- </option>";
										
										foreach($nationality as $row) { 

										

										if ($row['id'] == $vacantsea_edit['id_nationality'])

										{

											$n = "selected = 'selected'";	
										
										}
										
											
										echo  "<option value='$row[id]' > $row[name] </option>";
									?>

                                   

                                    <?php } ?>

                                    </select>

                                </div>

                                 <div class="form-group">

                                    <label>Expired Date</label>

                                    <div class="input-group">

                                    <div class="input-group-addon">

                                    <i class="fa fa-calendar"></i>

                                    </div>
									<?php $exp_date1 = date_create($vacantsea_edit['expired_date'])?>
                                    <input type="text" class="form-control pull-right" name="expired_date" id="datepick" 
                                    value="<?php echo date_format($exp_date1,"Y-m-d");?>" />

                                    </div> 

                                </div>
                                
                                <div class="form-group">  
                                	<label> Minimum Experience </label>
                                	<input type="text" name="minimum_experience" id="minimum_experience" value="<?=$vacantsea_edit["experience"]?>" class="form-control" >
                                </div>

                                
                            </div><!-- /.col-sm-4-->

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Detail</label>

                                    <textarea class="form-control" rows="4" id="detail" name="detail"><?php echo $vacantsea_edit['description'] ?></textarea>

                                </div>

                            </div>



                            </div>
                        <div class="clearfix"></div>

                     </div><!-- /.box-body -->

                     

                     <div class="box-footer">

                     <button type="button" class="btn btn-success" id="update_button" ><i class="glyphicon glyphicon-floppy-disk"></i> Update Vacantsea</button>

                     </div>

            </form>

            </div>

        



        </div><!-- modal-body-->

    </div><!-- modal-content -->

 </div>

</div>
<script type="text/javascript">

	$("#datepick").datepicker({

		dateFormat:"yy-mm-dd",

		changeMonth:true,

		changeYear:true

		

	});

	$(document).ready(function(e) {

       $(".modal-form-edit").modal("show");

    });

</script>                    