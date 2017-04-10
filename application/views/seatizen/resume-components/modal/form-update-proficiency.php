<div class="modal fade modal-form-update-prof modal-resume" id="" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog "><!-- large -->
    <div class="modal-content"> 
    	<div class="modal-header bg-primary" style="padding:-20px 0 -20px 0">
        	<h4> Edit Proficiency <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></h4>
            
        </div>
         
    	<div class="modal-body">
        	<script>
				function update_proficiency_process()
				{
                    // var data = $("#form-update-proficiency form").serialize()
					var formData = new FormData($("#form-update-proficiency form")[0]);
					
                    // alert(data);
					$.ajax({
						
						type:"post",
						url :"<?php echo base_url("seatizen/edit_proficiency_process"); ?>",
						data	:formData,
						// data: formData,
						async   : false,
						cache   : false,
						contentType	: false,
						processData	: false,
						dataType	   : "json",
						beforeSend     : function(){
							
							$("#proficiency-update-btn").button('loading');
							
						},
						
						success:function(data){
							
							$("#proficiency-update-btn").button('loading');
							if(data.status == "error")
							{
								$("#proficiency-update-btn").button('reset');
							}
							else
							{
								$("#proficiency-update-btn").button('loading');
								
							}
							
							$("#info").html(data.message);
							
							setTimeout(function() { 
								location.reload(); 
							}, 3000);
							
						}
						
					});
				}
				
				$(document).ready(function(e) {
                    $("#proficiency-update-btn").click(function(){
						
						update_proficiency_process();
						
					});
                });
				
				
			
			</script>
            <div id="info">
            
            </div>
        	<div id="form-update-proficiency">
            	<form action="#">
                	<input type="hidden" value="<?php echo $proficiency['id_sertifikat']?>" name="id_certificate"  />
                    <input type="hidden" value="<?php echo $proficiency["pelaut_id"] ?>" name="id_pelaut" >
                    
            		<div class="form-group">
                    	<label for="certificate" style="width:100%">Certificate </label>
                        <input type="text" name="certificate" class="form-control" style="width:80%" value="<?php echo $proficiency['sertifikat_stwc']?>" readonly>
                 </div>
                    <div class="form-group">
                    	<label for="certificate" style="width:100%">No Certificate </label>
                        <input type="text" name="no_certificate" id="no_certificate" class="form-control" style="width:80%" value="<?php echo $proficiency['no_sertifikat']?>">
                    </div>
                    <div class="form-group">
                        <label for="certificate" style="width:100%">Issued Place </label>
                        <input type="text" name="place_issue" id="place_issue" class="form-control" style="width:80%" value="<?php echo $proficiency['place_issue']?>">
                    </div>
                    <div class="form-group">
                    	<label for="certificate" style="width:100%">Issued Date </label>
                        <input type="text" name="date_issue" id="date_issue" class="form-control" style="width:80%" 
                        value="<?php echo date_picker_format($proficiency['date_issue'])?>">
                    </div>
                    <div class"form-group">
                        <label for="certificate" style="width:100%"> Expiry Date </label>
                        <input type="text" name="expired_date" id="expired_date" class="form-control" style="width:80%" value="<?php echo date_picker_format($proficiency['expired_date']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="expired_date">
                                <?php //$date_expired_lbl?>
                                Attachment
                        </label>
                        
                        <div>
                        <?=$proficiency['attachment']?>&nbsp;&nbsp;&nbsp;
                        
                        <input style="display:none" type='file' title="" name="attachment" id="attachment" autocomplete="off" >
                        <a class="label label-default" title="upload new attachment" onClick="$('#attachment').click()">&nbsp;edit&nbsp;</a>
                        &nbsp;
                        <span id="nama_file_resume" class="label label-info"></span>
                        </div>
                    
                    </div>
                    <button class="btn btn-success" id="proficiency-update-btn" type="button"> <span class="glyphicon glyphicon-floppy-disk"></span>&nbsp; Save </button>
    <button class="btn btn-primary" data-dismiss="modal"><span class="glyphicon glyphicon-remove-circle"></span>&nbsp; Cancel </button>
                    
                    
            	</form>
            </div>
        
        </div><!-- Modal Body -->
        
    </div><!-- Modal Content -->
  </div><!-- Modal dialog -->
</div><!-- Modal -->

<script>
	
	$("#attachment").change(function(){
		var pinp = $(this).val();
		$("#nama_file_resume").html(pinp);
	});
	
	$("#date_issue").datepicker({
		dateFormat:"yy-mm-dd",
		changeMonth:true,
		changeYear:true,
		yearRange: "-20:+0", // last hundred years
		maxDate:0
		
	});

    $("#expired_date").datepicker({
        dateFormat:"yy-mm-dd",
        changeMonth:true,
        changeYear:true
    })
	
	$(document).ready(function(e) {
        $(".modal-form-update-prof").modal({
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