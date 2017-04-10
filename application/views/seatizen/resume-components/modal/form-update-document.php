<div class="modal fade modal-resume" id="modal-form-update-document" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog"><!-- large -->
    <div class="modal-content"> 
    	<div class="modal-header bg-primary" style="padding:-20px 0 -20px 0">
        	<h4> Edit Document <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></h4>
            
        </div>
         
    	<div class="modal-body">
          <script>
		  	function update_document_process()
			{
				//var data = $("#form-update-document form").serialize();
				var formData = new FormData($("#form-update-document form")[0]);
				//alert(data);

				$.ajax({
					
					type		: "POST",
					url		 : "<?php echo base_url("seatizen/tes_update_document"); ?>",
					data		: formData,
					async	   : false,
                    cache	   : false,
					contentType : false,
                    processData : false,
					dataType	: "json",
					beforeSend  : function(){
                        $("#update-document-btn").button('loading');
                    },
					
					success:function(data){
						
						//alert(data);
						
						if(data.status == "error")
						{
							$("#update-document-btn").button('reset');
						}
						else
						{
							$("#update-document-btn").button('loading');
							
						}
						
						$("#info").html(data.message);
						
						setTimeout(function() { 
						location.reload(); 
						}, 3000);
						
					}
                    
					
				});
				
				
			}

			$("#update-document-btn").click(function(){
				
				update_document_process();
			});
			
		
		  
		  </script>


			<?php
				$a = explode("|",$document['type']);
				$type = $a[0];
			?>
          <div id="form-update-document">
          	<div id="info">              </div>
        	<form>                
                <div class="form-group">
                	
            		<label for="doc_type">
                    		Country 
                    </label>
                    <!-- <input type="" title="autocomplete" name="vessel_name" id="vessel_name" data-id="id_ship" class="form-control" style="width:80%" > -->
                    <?php         
                        $id_user = $id_pelautnya = $document["pelaut_id"]; 
						
                        $user = $this->nation_model->get_nationality_pelaut($id_user); 
                        $nation = $this->nation_model->get_nationality_except($user['kebangsaan']);
                        if($document['type'] == 'Passport' AND $document['country'] == $user['kebangsaan']){
                            // echo "saya disini";
                        ?>
                        <br>
                        <input type="text" name="national" value="<?php echo $user['kebangsaan']; ?>"  class="form-control" style="width:80%" readonly> 
                        <?php
                        } else {
                        ?>
                        <input type="text" name="national" value="<?php echo $document['country']; ?>" class="form-control" style="width:80%;" readonly>
                        <?php
                        } 
					?> 
					<input type="hidden" value="<?php echo $id_pelautnya; ?>" name="pelaut_id" />
                    <input type="hidden" value="<?php echo $this->session->userdata("username"); ?>" name="username" />
                    <input type="hidden" value="<?php echo $document['document_id']; ?>" name="id_update" />       
                    <input type="hidden" name="tipenya" value="<?php echo $document['type']; ?>">
                   <?php /*       ?>

                    <select class="form-control" style="width: 50%;" name="national">
	<!--                        <option value="">- select  -</option> -->

                        <?php 
                        $dokko = $document['country'];
                         $z = $this->db->query("SELECT country FROM document_tr WHERE pelaut_id = '$id_user' AND 
                            type_document = 'document' AND country != '$dokko'");
                        $xx = $z->result_array();
                        foreach($xx as $m){
                            $negg[] = $m['country'];
                        }
                       //$nation = $this->nation_model
                            foreach($nation as $row)
                            {


                                if(!in_array($row['name'],$negg)){ 
                            	
                                $select_nation = '';
                            	if($row['name'] == $type || $row['name'] == $document['country']) {
								$select_nation = "selected='selected'";
                            	}?>
                                <option value="<?= $row['name'] ?>" <?=$select_nation?>><?= $row['name'] ?></option>
                                <?php
                            }  else{

                            }} 
                        ?>

                    </select>
                    <?php } */ ?>
                 
                </div>
                
                <div class="form-group">
            		<label for="number"> 
                    		Number 
                    </label> 
                    
                    <input type="text" value="<?php echo $document['number']; ?>" name="number" id="number" placeholder="" class="form-control" style="width:80%"  />
                    
                  
            	</div>
                <div class="form-group">
                	<label for="place">
                    		Issued Place 
                    </label>
                    <input type="text" value="<?php echo $document['place']; ?>" name="place" id="place" class="form-control" style="width:80%"  />
                
                </div>
                <div class="form-group">
                	<label for="date_issued">
                        Issued Date
                    		<?php //$date_issued_lbl?>
                    </label>
                    <input type="text" title="" value="<?php echo date_picker_format($document['date_issued']); ?>" name="date_issued" id="date_issued" class="form-control" style="width:80%" autocomplete="off" >
                
                </div>
                <div class="form-group">
                	<label for="expired_date">
                        Expiry Date
                    		<?php //$date_expired_lbl?>
                    </label>
                    <input type="text" title="" value="<?php echo date_picker_format($document['date_expired']); ?>" name="date_expired" id="date_expired" class="form-control" style="width:80%" autocomplete="off">
                
                </div>
                <div class="form-group">
                    <label for="expired_date">
                            <?php //$date_expired_lbl?>
                            Attachment
                    </label>
                    
                    <div>
                    <?=$document['attachment']?>&nbsp;&nbsp;&nbsp;
                    
                    <input style="display:none" type='file' title="" name="attachment" id="attachment" autocomplete="off" >
                    <a class="label label-default" title="upload new attachment" onClick="$('#attachment').click()">&nbsp;edit&nbsp;</a>
                    &nbsp;
                        <span id="nama_file_resume" class="label label-info"></span>
                    </div>
                
                </div>
                 
                <button class="btn btn-success" id="update-document-btn" type="button"> <span class="glyphicon glyphicon-floppy-disk"></span>&nbsp; Save </button>
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
        $("#modal-form-update-document").modal({
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
