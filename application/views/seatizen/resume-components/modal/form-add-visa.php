<div class="modal fade modal-resume" id="modal-form-add-visa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog"><!-- large -->
        <div class="modal-content">
            <div class="modal-header bg-primary" style="padding:-20px 0 -20px 0">
                <h4> Add Visa <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></h4>

            </div>



            <div class="modal-body">
                <script>
                    function add_visa_process()
                    {
                        //var data = $("#form-add-visa form").serialize();
                        var formData = new FormData($("#form-add-visa form")[0]);
                        $.ajax({
                            type:"POST",
                            url		 :"<?php echo base_url("seatizen/add_document_visa"); ?>",
                            data		:formData,
                            // data: formData,
                            async	   : false,
                            cache	   : false,
                            contentType : false,
                            processData : false,
							dataType	: "json",
                            beforeSend  : function(){
								//$("#add-visa-btn").button('loading');
							},
							
							success:function(data){
								
								if(data.status == "error")
								{
									$("#add-visa-btn").button('reset');
								}
								else
								{
									$("#add-visa-btn").button('loading');
									
								}
								
								$("#info_visa").html(data.message);
								
								setTimeout(function() { 
									location.reload(); 
								}, 3000);
								
							}


                        });
                    }

                    $("#add-visa-btn").click(function(){

                        add_visa_process();
                    });

                </script>
                <div id="form-add-visa">
                    <div id="info_visa">

                    </div>
                    <form>
                        <?php // via json encode ?>
                        <div class="form-group">
                            <input type="hidden" value="<?php echo $id_pelautnya; ?>" name="pelaut_id" />
                          
                            <input type="hidden" value="<?php echo $this->session->userdata("username"); ?>" name="username" />
                            <label for="doc_type">
                                Type
                            </label>
                            <!-- <input type="" title="autocomplete" name="vessel_name" id="vessel_name" data-id="id_ship" class="form-control" style="width:80%" > -->
                            <select class="form-control" style="width: 50%;" name="visa_type" id="visa_type">
                                <option value=""> Select Visa </option>
                                <?php 
                                $this->load->model('document_model');
                                $username = $this->session->userdata('username');
                                $visaku = $this->document_model->get_document_visa($username);
                                foreach($visaku as $zz){
                                    $x[] = $zz['type'];
                                }


                                $vi = $this->document_model->list_visa();
                                foreach($vi as $viz){ 

                                    if(!in_array($viz['nama_visa'], $x)) { 
                                                                    ?>
                                <option value="<?=$viz['nama_visa'];?>"> <?=$viz['nama_visa'];?> </option>
                                <?php }else  { } 
                                    
                                }
?>
                             <option value="other"> Other </option>
                            </select>
                            <br>
                            <input type="text" value="" name="type" id="type" placeholder="Type of visa" class="form-control" style="width:80%;" />
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
                            <input type="text" value="" name="place_issue" id="place" class="form-control" style="width:80%"  />

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
                            <input type="" title="" name="expired_date" id="date_expired" class="form-control" style="width:80%" autocomplete="off">

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

                        <button class="btn btn-success" data-loading-text="Loading ... " id="add-visa-btn" type="button"> <span class="glyphicon glyphicon-floppy-disk"></span>&nbsp; Save </button>
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
	
    $("#visa_type").change(function(){
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
        $("#modal-form-add-visa").modal({
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