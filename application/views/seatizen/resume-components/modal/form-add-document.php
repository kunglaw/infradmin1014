<?php
$id_pelaut = $id_pelautnya;

?>
<div class="modal fade modal-resume" id="modal-form-add-document" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog"><!-- large -->
    <div class="modal-content"> 
    	<div class="modal-header bg-primary" style="padding:-20px 0 -20px 0">
        	<h4> Others Seaman Book <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></h4>
            
        </div>

<!--        --><?php //print_r($myDocument); ?>
         
    	<div class="modal-body">
          <script>
		  	function add_document_process()
			{
				// var data = $("#form-add-document form").serialize();
//                alert(data);
                //alert('data');
                var formData = new FormData($("#form-add-document form")[0]);
              
				$.ajax({

				    type:"POST",
					url:"<?php echo base_url("seatizen/add_document_process"); ?>",
					data:formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType:"json",
                    beforeSend  : function(){
                        //$("#add-document-btn").button('loading');
                    },
					
					success:function(data){
						
						//alert(data.message);
						
						if(data.status == "error")
						{
							$("#add-document-btn").button('reset');
						}
						else
						{
							$("#add-document-btn").button('loading');
							
							setTimeout(function() { 
								location.reload(); 
							}, 3000);
							
						}
						
						$("#info").html(data.message);
						
						
						
					}
				});
			}
			
			$("#add-document-btn").click(function(){
                //  alert('aku disini');
				add_document_process();
			});
		  
		  </script>
          <div id="form-add-document">
          	<div id="info">   
            

            </div>
        	<form>
                <?php // via json encode ?>
                <div class="form-group">
                	<input type="hidden" value="<?php echo $id_pelaut; ?>" name="pelaut_id" />
                	<input type="hidden" value="document" name="source" />
                    <input type="hidden" value="<?php echo $this->session->userdata("username"); ?>" name="username" />
            
            		<label for="doc_type">
                    		Country
                    </label>
                    <!-- <input type="" title="autocomplete" name="vessel_name" id="vessel_name" data-id="id_ship" class="form-control" style="width:80%" > -->
                    <select class="form-control" style="width: 50%;" name="national">
                        <option value="">- select -</option>

                        <?php

                        
                        $this->db = $this->load->database(DB2_GROUP, TRUE);
                        $user = $this->nation_model->get_nationality_pelaut($id_pelaut);                      
                        $nation = $this->nation_model->get_nationality_except($user['kebangsaan']);

                        $k = $this->db->query("SELECT country FROM document_tr WHERE pelaut_id = '$id_user' AND 
                            type_document = 'document'");
                        $l = $k->result_array();
                        foreach($l as $m){
                            $n[] = $m['country'];
                        }

                       //$nation = $this->nation_model
                            foreach($nation as $row)
                            {
                                if(!in_array($row['name'],$n)){ ?>

                                <option value="<?= $row['name'] ?>"><?= $row['name'] ?></option>
                               <?php         }   
                                    else {

                                    }
                                ?>
                                <?php
                            }
                        ?>
                      
                    </select>

                    <br><!--
                   <input type="text" value="" name="type" id="type" placeholder="type of document .. " class="form-control" style="width:80%;" /> -->

            	</div>
                
                <div class="form-group">
            		<label for="number">
                    		Number
                    </label>
                    
                    <input type="text" value="" name="number" id="number" placeholder="" class="form-control" style="width:80%"  />
                    
                  
            	</div>
                <div class="form-group">
                	<label for="place">
                    	   Issued Place
                    </label>
                    <input type="text" value="" name="place" id="place" class="form-control" style="width:80%"  />
                
                </div>
                <div class="form-group">
                    <label for="date_issued">
                        <?php //$date_issued_lbl?>
                        Issued date
                    </label>
                    <input type="text" value="" name="date_issued" id="date_issued" class="form-control" style="width:80%" autocomplete="off">

                </div>
<!--                <div class="form-group">-->
<!--                	<label for="date_issued">-->
<!--                    		Date Issued-->
<!--                    </label>-->
<!--                    <input type="" title="" name="date_issued" id="date_issued" class="form-control" style="width:80%" autocomplete="off" >-->
<!--                -->
<!--                </div>-->
                <div class="form-group">
                	<label for="expired_date">
                    		<?php //$date_expired_lbl?>
                            Expiry date
                    </label>
                    <input title="" name="date_expired" id="date_expired" class="form-control" style="width:80%" autocomplete="off">
                
                </div>
                <div class="form-group">
                        <label for="expired_date">
                                <?php //$date_expired_lbl?>
                                Attachment
                        </label>
                        
                        <div>
                        
                        <input style="display:none" type='file' title="" name="attachment" id="attachment" autocomplete="off" >
                        <a class="label label-default" title="upload new attachment" onClick="$('#attachment').click()">&nbsp;edit&nbsp; 
                         </a>
                         &nbsp;
                        <span id="nama_file_resume" class="label label-info"></span>
                        </div>
                    
                 </div>
                 
                <button class="btn btn-success" id="add-document-btn" type="button" data-loading-text="Loading .... " > <span class="glyphicon glyphicon-floppy-disk"></span>&nbsp; Save </button>
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
	
    $("#doc_type").change(function(){
        var pilihan = $(this).val();
        if(pilihan == 'other') $("#type").show();
        else $("#type").hide().val("");
    });

	$("#date_issued").datepicker({
		dateFormat:"yy-mm-dd",
		changeMonth:true,
		changeYear:true,
		gotoCurrent: true,
		yearRange: "<?=$date_issued?>",
		maxDate:0
		
	});
	
	$("#date_expired").datepicker({
		dateFormat:"yy-mm-dd",
		changeMonth:true,
		changeYear:true,
		gotoCurrent: true,
		yearRange: "<?=$date_expired?>"
		
	});
	
	$(document).ready(function(e) {
        $("#type").hide();
        $("#modal-form-add-document").modal({
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