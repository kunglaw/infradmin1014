<div class="modal fade modal-resume" id="modal-form-update-visa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog"><!-- large -->
    <div class="modal-content"> 
    	<div class="modal-header bg-primary" style="padding:-20px 0 -20px 0">

        
        	<h4> Edit Visa <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></h4>
            
        </div>
         
    	<div class="modal-body">
          <script>
		  	function update_visa_process()
			{
				//var data = $("#form-update-visa form").serialize();
				var formData = new FormData($("#form-update-visa form")[0]);
				//alert(data);
				$.ajax({
					
					type:"POST",
					url:"<?php echo base_url("seaman/resume_process/update_visa_process"); ?>",
					data: formData,
					 // data: formData,
					async	   : false,
					cache	   : false,
					contentType : false,
					processData : false,
					dataType	: "json",
					beforeSend  : function(){
						$("#update-visa-btn").button('loading');
					},
					
					success:function(data){
						
						if(data.status == "error")
						{
							$("#update-visa-btn").button('reset');
						}
						else
						{
							$("#update-visa-btn").button('loading');
							
						}
						
						$("#info_visa_update").html(data.message);
						
						// setTimeout(function() { 
						// 	location.reload(); 
						// }, 3000);
						
					}
					
				});
				
				
			}

			$("#update-visa-btn").click(function(){
				
				update_visa_process();
			});
			
		
		  
		  </script>


			

          <div id="form-update-visa">
          	<div id="info_visa_update">       </div>
        	<form>                
                <div class="form-group">
                	<input type="hidden" value="<?php echo $this->session->userdata("id_user"); ?>" name="pelaut_id" />
                    <input type="hidden" value="<?php echo $this->session->userdata("username"); ?>" name="username" />
                    <input type="hidden" value="<?php echo $document['document_id']; ?>" name="id_update" />
            		<label for="type">
                    		Type
                    </label>
                    <!-- <input type="" title="autocomplete" name="vessel_name" id="vessel_name" data-id="id_ship" class="form-control" style="width:80%" > -->
                   	<?php
                   		$dat = $this->db->query("SELECT nama_visa FROM visa");
                   		$ff = $dat->result_array();
                   		foreach($ff as $x){
                   			$tes[] = $x['nama_visa'];
                   		}

                   		if(in_array($visa['type'],$tes)){ ?>
       				<input type="text" value="<?php echo $visa['type']; ?>" name="type" id="type"  class="form-control" 
                   readonly="readonly"
                   style="width:80%"  />
                   	<?php	} else { ?>
                   	<input type="text" value="<?php echo $visa['type']; ?>" name="type" id="type" placeholder="type of document .. " class="form-control" 
                   style="width:80%"  />
               <?php    	} ?>

                  
                  
            	</div>
                
                <div class="form-group">
            		<label for="number">
                    		Number
                    </label>
                    
                    <input type="text" value="<?php echo $visa['number']; ?>" name="number" id="number" placeholder="" class="form-control" style="width:80%"  />
                    
                  
            	</div>
                <div class="form-group">
                	<label for="place">
                    		Issued Place
                    </label>
                    <input type="text" value="<?php echo $visa['place']; ?>" name="place" id="place" class="form-control" style="width:80%"  />
                
                </div>
                <div class="form-group">
                	<label for="date_issued">
                    			Issued Date
                    		<?php //$date_issued_lbl?>
                    </label>
                    <input type="text" title="" value="<?php echo date_picker_format($visa['date_issued']); ?>" name="date_issued" id="date_issued" class="form-control" style="width:80%" autocomplete="off" >
                
                </div>
                <div class="form-group">
                	<label for="expired_date">
                		Expiry Date
                    		<?php //$date_expired_lbl?>
                    </label>
                    <input type="text" title="" value="<?php echo date_picker_format($visa['date_expired']); ?>" name="date_expired" id="date_expired" class="form-control" style="width:80%" autocomplete="off">
                
                </div>
                <div class="form-group">
                    <label for="expired_date">
                            <?php //$date_expired_lbl?>
                            Attachment
                    </label>
                    
                    <div>
                    <?=$visa['attachment']?>&nbsp;&nbsp;&nbsp;
                    
                    <input style="display:none" type='file' title="" name="attachment" id="attachment" autocomplete="off" >
                    <a class="label label-default" title="upload new attachment" onClick="$('#attachment').click()">&nbsp;edit&nbsp;</a>
                    &nbsp;
                    <span id="nama_file_resume" class="label label-info"></span>
                    </div>
                
                </div>
                 <input type="hidden" name="visa_id" value="<?=$visa['document_id'];?>">
                <button class="btn btn-success" id="update-visa-btn" type="button"> <span class="glyphicon glyphicon-floppy-disk"></span>&nbsp; Save </button>
    			<button class="btn btn-primary" data-dismiss="modal"><span class="glyphicon glyphicon-remove-circle"></span>&nbsp; Cancel </button>
            </form>
          </div>
        </div><!-- modal-body -->
        
    </div><!-- modal-content -->
  </div><!-- modal-dialog --> 
</div><!-- modal -->

<script>
	
	$("#attachment").change(function(){
		var pinp = $(this).val();
		$("#nama_file_resume").html(pinp);
	});
	
	$("#date_issued").datepicker({
		dateFormat:"yy-mm-dd",
		changeMonth:true,
		changeYear:true,
		yearRange: "<?=$date_issued?>", // last hundred years
		maxDate:0
	});
	
	$("#date_expired").datepicker({
		dateFormat:"yy-mm-dd",
		changeMonth:true,
		changeYear:true,
		yearRange: "<?=$date_expired?>", // last hundred years
		
	});
	
	$(document).ready(function(e) {
        $("#modal-form-update-visa").modal({
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
