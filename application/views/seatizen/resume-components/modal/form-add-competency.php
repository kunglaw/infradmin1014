<?php $id_pelaut = $id_pelautnya; ?>
<div class="modal fade modal-resume" id="modal-form-add-comp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog "><!-- large -->
    <div class="modal-content"> 
    	<div class="modal-header bg-primary" style="padding:-20px 0 -20px 0">
        	<h4> Add COC and Endorsement <!-- Certificate of Competency --> 
            <button type="button" id="close-modal-btn" class="close" data-dismiss="modal">
            	<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
            </button>
            </h4>
            
        </div>
         
    	<div class="modal-body">
        	<div id="add-competency-info">
            	test
            </div>
        	<script>
				function add_competency_process()
				{
					var formData = new FormData($("#form-add-competency form")[0]);
					
					$.ajax({
						
						type:"POST",
						url	 :"<?php echo base_url("seatizen/add_competency_process"); ?>",
						data	:formData,
						// data: formData,
						async   : false,
						cache   : false,
						contentType	: false,
						processData	: false,
						dataType	   : "json",
						   beforeSend  : function(){
							$("#save-competency-btn").button('loading');
						},
						
						success:function(data){
							
							if(data.status == "error")
							{
								$("#save-competency-btn").button('reset');
							}
							else
							{
								$("#save-competency-btn").button('loading');
								
							}
							
							$("#add-competency-info").html(data.message);
							// setTimeout(function() { 
							// 	location.reload(); 
							// }, 3000);
							
						}
						
					});	
					
				}
				
				$("#save-competency-btn").click(function(){
					
					add_competency_process();
				})
				
			
			</script>
            
            <div id="form-add-competency">
            	<form role="form" class="" method="post">
                	<div class="form-group">
                    	<!-- <label for="" style="display:block">Certificate of Recognition </label>-->
                        	

						
							<label>
								Country
							</label>
                        <select name="negara" id="negara" class="form-control" style="width:80%" required>
                       		<option value=""> Country </option>
                        	

                        <?php

                        $id_user  = $this->session->userdata('id_user');
                        $this->load->model('nation_model');
                        $user = $this->nation_model->get_nationality_pelaut($id_user);                      
                        $nation = $this->nation_model->get_nationality_except($user['kebangsaan']);

                        /* $k = $this->db->query("SELECT negara FROM competency_tr WHERE pelaut_id = '$id_user'");
                        $l = $k->result_array();
                        foreach($l as $m){
                            $n[] = $m['negara'];
                        }*/

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
					</div>
                    <input type="hidden" value="<?=$id_pelaut ?>" name="pelaut_id" />
                	
                    <div class="form-group">
                    	<label> Grade License</label>
                        <input type="text" value="" name="grade_license" id="grade_license" class="form-control" 
                        style="width:80%">
                    </div>
                    
                        
                    <input type="hidden" value="cor" name="type"  />
                    
                    <div class="form-group">
                    	<label for="" style="display:block">No License </label>
                        <input type="text" value="" name="no_license" id="no_license" class="form-control" style="width:80%">
                    </div>
                    <div class="form-group">
                    	<label for="" style="display:block">Issued Place </label>
                        <input type="text" value="" name="place_issue" id="place_issue" class="form-control" style="width:80%">
                    </div>
                    <div class="form-group">
                    	<label for="" style="display:block">Issued Date</label>
                        <input type="text" value="" name="date_issue" id="date_issue" class="form-control" style="width:80%; background-color: white" readonly>
                    </div>
                    <div class="form-group">
                    	<label for="" style="display:block">Expiry Date </label>
                        <input type="text" value="" name="expired_date" id="expired_date" class="form-control" style="width:80%; background-color: white" readonly>
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
                   <!--  <div class="form-group">
                    	<label for="" style="display:block">Country </label>
                        <input type="text" value="" name="negara" id="negara" class="form-control" style="width:80%">
                       
                        
                    </div> -->                    
    				<button class="btn btn-danger pull-right" data-dismiss="modal"> <span class="glyphicon glyphicon-remove-circle"></span>&nbsp; <b> Cancel </b> </button>
                    <span class="pull-right">&nbsp;</span>
                    <button class="btn btn-success pull-right" id="save-competency-btn" type="button" data-loading-text="Loading..."> 
                     	<span class="glyphicon glyphicon-floppy-disk"></span>&nbsp; <b> Save </b>
                    </button>
                    
                    <span class="clearfix"></span>
                    

            	</form>
            </div>
        

        </div><!-- modal-body-->
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->

<script type="text/javascript">

	$("#attachment").change(function(){
		var pinp = $(this).val();
		$("#nama_file_resume").html(pinp);
	});
	
	$("#date_issue").datepicker({
		dateFormat:"yy-mm-dd",
		changeMonth:true,
		changeYear:true,
		yearRange: "<?=$date_issued?>",
		maxDate:0
		
	}).on('change', function () {
        var myVal = $(this).val();
        // alert(myVal);
        var minDate = new Date(myVal);

  
        $('#expired_date').removeClass('hasDatepicker').datepicker({
            dateFormat:"yy-mm-dd",
            changeMonth:true,
            changeYear:true,
            minDate : minDate

        });
    });
	
	$("#expired_date").datepicker({
		dateFormat:"yy-mm-dd",
		changeMonth:true,
		changeYear:true,
		yearRange: "<?=$date_expired?>",
		
	}).on('change', function () {
        var myVal = $(this).val();
        // alert(myVal);
        var minDate = new Date(myVal);

        /* Pengecekan tidak lebih besar dari hari ini */
        var x = new Date();
        if(x > minDate) minDate = minDate;
        else minDate = x;

        $('#date_issue').removeClass('hasDatepicker').datepicker({
            dateFormat:"yy-mm-dd",
            changeMonth:true,
            changeYear:true,
            maxDate : minDate

        });
    });
	
	$(document).ready(function(e) {
        $("#modal-form-add-comp").modal({
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