<div class="modal fade modal-resume" id="modal-form-add-medical" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog"><!-- large -->
        <div class="modal-content">
            <div class="modal-header bg-primary" style="padding:-20px 0 -20px 0">
                <h4> Add Medical Record <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></h4>

            </div>
            
            <div class="modal-body">
                <script>
                    function add_medical_process()
                    {
                 
                        var formData = new FormData($("#form-add-medical form")[0]);
                        
                        $.ajax({
                            type	:"POST",
                            url	 :"<?php echo base_url("seatizen/add_document_medical"); ?>",
                            data	:formData,
                            // data: formData,
                            async   : false,
                            cache   : false,
                            contentType	: false,
                            processData	: false,
                         	dataType	   : "json",
                            beforeSend 	 : function(){
								
                            	$("#add-medical-btn").button('loading'); 
							       
                            },
							error:function(test)
							{
								$("#add-medical-btn").button('reset'); 
							
							},
                            success:function(data){
							
								if(data.status == "error")
								{
									$("#add-medical-btn").button('reset');	
								}
								else
								{
									$("#add-medical-btn").button('loading');
								}
                                $("#info").html(data.message);
                                // $("#modal-form-add-medical").hide();
                                // location.reload();
                                // setTimeout(function() { location.reload(); }, 3000);
                            }

                        });
                    }

                    function fillHiddenField(value){
						
                        var source = "";
                        if(value == 'Medical Certificate') source = "medical_cert";
                        else source = "medical";

                        $("#source").val(source);
                    }

                    $("#add-medical-btn").click(function(){

                        add_medical_process();
                    });

                </script>
                <div id="form-add-medical">
                    <div id="info">

                    </div>
                    <form>
                        <?php // via json encode ?>
                        <div class="form-group">
                            <input type="hidden" value="<?php echo $id_pelautnya; ?>" name="pelaut_id" />
                            <!-- <input type="hidden" value="medical" name="source" /> -->
                            <input type="hidden" value="<?php echo $usernamenya; ?>" name="username" />
                            <label for="doc_type">
                                Type
                            </label>
                            <!-- <input type="" title="autocomplete" name="vessel_name" id="vessel_name" data-id="id_ship" class="form-control" style="width:80%" > -->
                            <input type='hidden' name='source' id='source' value=''>
                            <select class="form-control" style="width: 50%;" name="document_type" id="doc_type" onchange='fillHiddenField(this.value)'>
                                <option value="">- select -</option>
                                <?php

                                    $this->load->model('document_model');

                                //iqbal
                            $document_pribadi = $this->db->query("SELECT type FROM document_tr WHERE pelaut_id = '$id_pelaut' AND (type_document = 'medical' or type_document = 'medical_cert')");
                            $a = $document_pribadi->result_array();
                            foreach($a as $b){
                                $xz[] = $b['type'];
                            }



                                foreach($myDocument as $row)
                                {  
                                        if(!in_array($row['medical'],$xz)){ ?>
                             ?>
                                    <option value="<?= $row['medical'] ?>"><?= $row['medical'] ?> </option>
                                 <?php
                                  } else{

                                  }
                                }
                                ?>
                             <option value="other"> Other </option>
                            </select>
                            <br>
                            <input type="text" value="" name="type" id="type" placeholder="type of document .. " class="form-control" style="width:80%;" />

                        </div>

                        <div class="form-group">
                            <label for="number">
                                Number
                            </label>

                            <input type="text" value="" name="number" id="number" placeholder="" class="form-control" style="width:80%"  />


                        </div>
                        <div class="form-group">
                            <label for="place">
                                Place
                            </label>
                            <input type="text" value="" name="place" id="place" class="form-control" style="width:80%"  />

                        </div>
                        <div class="form-group">
                            <label for="date_issued">
                                    Issued Date
                            </label>
                            <input type="" title="" name="date_issued" id="date_issued" class="form-control" style="width:80%" autocomplete="off" >
                        </div>
                        <div class="form-group">
                            <label for="expired_date">
                                Expiry Date
                            </label>
                            <input type="" title="" name="date_expired" id="date_expired" class="form-control" style="width:80%" autocomplete="off">

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

                        <button class="btn btn-success" id="add-medical-btn" type="button" data-loading-text="Loading ...."> <span class="glyphicon glyphicon-floppy-disk"></span>&nbsp; Save </button>
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
        yearRange: "<?=$date_issued?>", // last hundred years
		maxDate:0

    });

    $("#date_expired").datepicker({
        dateFormat:"yy-mm-dd",
        changeMonth:true,
        changeYear:true,
        gotoCurrent: true,
        yearRange: "<?=$date_expired?>" // last hundred years

    });

    $(document).ready(function(e) {
        $("#type").hide();
        $("#modal-form-add-medical").modal({
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