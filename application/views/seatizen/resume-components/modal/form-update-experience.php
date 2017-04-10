<div class="modal fade modal-resume" id="modal-form-update-experience" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

  <div class="modal-dialog"><!-- large -->

    <div class="modal-content"> 

    	<div class="modal-header bg-primary" style="padding:-20px 0 -20px 0">

        	<h4> Edit Experience <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> </h4>  
        </div>

    	<div class="modal-body">

          <script>

		  	function reset_juga()
			{
				//load_ship_type();

				load_ship();

			}

		  	function update_experience_process()
			{

				

				$.ajax({

					

					type:"POST",

					url:"<?php echo base_url("seatizen/update_experience_process"); ?>",

					data:$("#form-update-experience form").serialize(),

					success:function(data){

							

						$("#info").html(data);

						//setTimeout(function() { location.reload(); }, 2000);

					}

					

				});

				

				

			}

			function load_ship_type()
			{

				$.ajax({

				  url:'<?php echo base_url("seatizen/resume_data"); //get_ship_type ?>',

				  type:'POST',

				  data: 'x=1&function=get_ship_type&curr_type=<?php echo $experience['ship_type_id'] ?>',

				  success: function(data) {

					  //$("info").html(json);

					$("#ship_type").html(data);

					  

					  

				  }

				});	

			}

			

			function load_ship_by_type()

			{

				var type_id = $("#ship_type").val();

				

				$.ajax({

				  url:'<?php echo base_url("seatizen/resume_data"); //get_ship_bytype ?>',

				  type:'POST',

				  data: 'x=1&function=get_ship_bytype&type_id='+type_id,

				 // dataType: 'json',

				  success: function(data) {

					//alert(data);

					//$("#info").html("type_id="+type_id+"&load_ship_by_type()&get_ship_bytype"+data);

					$("#vessel_id").html(data);

					 

					  

				  }

				});

				

				

			}

			

			function load_ship_type_row()

			{

				var vessel_id = $("#vessel_id").val();

							

				$.ajax({

				  url:'<?php echo base_url("seatizen/resume_data"); // get_ship_type_byvi ?>',

				  type:'POST',

				  data: 'x=1&function=get_ship_type_byvi&vessel_id='+vessel_id,

				 // dataType: 'json',

				  success: function(data) {

					//$("#info").html("vessel_id="+vessel_id+"&load_ship_type_row()&get_ship_type_byvi&"+data);

					$("#ship_type").html(data);

					 

					  

				  }

				});	

			}

			

			$("#add-experience-btn").click(function(){

				

				update_experience_process();

			});

		  	

			$(document).ready(function(e) {

                load_ship_type();

            });

			

		  </script>

          <div id="form-update-experience">

          	<div id="info">   

            

            

            </div>

        	<form>         

                <input type="hidden" value="<?=$experience["pelaut_id"] ?>" name="pelaut_id" />
                <input type="hidden" value="<?php echo $experience['experience_id']?>" name="experience_id" />       

                <?php // via json encode ?>

                <div class="form-group">

                	

            		<label for="vessel_name">

                    		Vessel Name

                    </label>

                    <!-- <input type="" title="autocomplete" name="vessel_name" id="vessel_name" data-id="id_ship" class="form-control" style="width:80%" > -->

                    <input type="text" name="vessel_name" id="vessel_name" value="<?=$experience['ship_name']?>" class="form-control" style="width:80%">

                  

            	</div>

                

                <div class="form-group">

                	<div class="row">

                      

                      <div class="col-md-3">

                        <label>Size</label>

                        <input type="text" value="<?=$experience['weight']?>" name="weight" id="weight" class="form-control"/>

                      </div>

                      

                      <div class="col-md-3">

                         <label>&nbsp;</label>

                        <?php

							$selected_grt = "";

							$selected_dwt = "";

							if($experience['satuan'] == "GRT")

							{

								$selected_grt = "selected='selected'";

							}

							else if($experience['satuan'] == "DWT")

							{

								$selected_dwt = "selected='selected'";

							} else if($experience['satuan'] == "m3"){

								$selected_m3 = "selected='selected'";

							} else if($experience['satuan'] = "TEU"){

								$selected_teu = "selected='selected'";

							}

						?>

                        <select name="satuan" class="form-control" >

                        	<option value="GRT" <?=$selected_grt?> >GRT</option>

                        	<option value="DWT" <?=$selected_dwt?> >DWT</option>

                        	<option value="m3" <?=$selected_m3?> > M&sup3;</option>

                        	<option value="TEU" <?=$selected_teu?>> TEU </option>

                        </select>

                      </div>

                      

                    </div>

                </div>

                

                <div class="form-group">

            		<label for="ship_type">

                    		Ship Type

                    </label>

                    <info></info>

                    <select name="ship_type" id="ship_type" class="form-control" style="width:80%" >

                    

                    </select>

                  

            	</div>

                <div class="form-group">

                	<label for="rank_id">

                    		Rank

                    </label>

                   <select class="form-control" name="rank_id" id="rank_id" style="width:80%" >

                   

                    </select>

                     <script>

						$(document).ready(function(e) {

							

                            $.ajax({

							  url:'<?php echo base_url("seatizen/resume_data"); ?>', // menuju controller resume_data

							  type:'POST',

							  data: 'x=1&function=rank_json&id_department=<?php echo $resume['profile']['department']  ?>&curr_rank=<?php echo $experience['rank_id'] ?>',

							  

							  

							  success: function(data) {

								 

								  $("#rank_id").html(data);

							  }

							});

                        });

					

					

					</script>

                

                </div>

                <div class="form-group">

                	<label for="trade_area_line">

                    		Trade Area Line

                    </label>

                    <input type="" title="" name="trade_area_line" id="trade_area_line" value="<?php echo $experience["trade_area"] ?>" class="form-control" style="width:80%" >

                

                </div>

                <div class="form-group">

                	<label for="company">

                    		Company

                    </label>

                    <input type="" title="" name="company" id="company" data-id="id_company" class="form-control" value="<?php echo $experience["company"] ?>" style="width:80%" >

                

                </div>

                 <div class="form-group">

                	<label for="periode_from">

                    		Sign On

                    </label>

                    <input type="" title="" name="periode_from" id="periode_from" value="<?php echo $experience["periode_from"] ?>" data-id="periode_from" class="form-control" style="width:80%" >

                

                </div>

            	<div class="form-group">

                	<label for="periode_to">

                    		Sign Off 

                    </label>

                    <input type="" title="" name="periode_to" id="periode_to" value="<?php echo $experience["periode_to"] ?>" data-id="periode_to" class="form-control" style="width:80%" >

                

                </div>

                <button class="btn btn-success" id="add-experience-btn" type="button"> <span class="glyphicon glyphicon-floppy-disk"></span>&nbsp; Save </button>

    			<button class="btn btn-primary" data-dismiss="modal"><span class="glyphicon glyphicon-remove-circle"></span>&nbsp; Cancel </button>

            </form>

          </div>

        </div><!-- modal-body -->

        

    </div><!-- modal-content -->

  </div><!-- modal-dialog --> 

</div><!-- modal -->



<script>

	

	$("#periode_from").datepicker({

		dateFormat:"yy-mm-dd",

		changeMonth:true,

		changeYear:true,

		yearRange: "-20:+0", // last hundred years

		maxDate:0

		

	});

	

	$("#periode_to").datepicker({

		dateFormat:"yy-mm-dd",

		changeMonth:true,

		changeYear:true,

		yearRange: "-30:+0", // last hundred years

		maxDate:0 

		

	});

	

	$(document).ready(function(e) {

        $("#modal-form-update-experience").modal({

			backdrop:"static",

			show:true	

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