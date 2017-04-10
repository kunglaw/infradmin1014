<div class="modal fade modal-form-update-prof modal-resume" id="" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog "><!-- large -->
    <div class="modal-content"> 
        <div class="modal-header bg-primary" style="padding:-20px 0 -20px 0">
            <h4> Form Update Profiency <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></h4>
            
        </div>
         
        <div class="modal-body">
            <script>
                function update_profiency_process()
                {
                    $.ajax({
                        
                        type:"post",
                        url :"<?php echo base_url("seaman/resume_process/edit_profiency_process"); ?>",
                        data:$("#form-update-profiency form").serialize(),
                        success: function(data){
                            $("#info").html(data);  
                            setTimeout(function() { location.reload(); }, 2000);
                        }
                        
                    });
                }
                
                $(document).ready(function(e) {
                    $("#profiency-update-btn").click(function(){
                        
                        update_profiency_process();
                        
                    });
                });
                
                
            
            </script>
            <div id="info">
            
            </div>
            <div id="form-update-profiency">
                <form action="#">
                    <input type="hidden" value="<?php echo $profiency['id_sertifikat']?>" name="id_certificate"  />
                    <div class="form-group">
                        <label for="certificate" style="width:100%">Certificate </label>
                        <input type="text" name="certificate" class="form-control" style="width:80%" value="<?php echo $profiency['sertifikat_stwc']?>">
                    </div>
                    <div class="form-group">
                        <label for="certificate" style="width:100%">No Certificate </label>
                        <input type="text" name="no_certificate" id="no_certificate" class="form-control" style="width:80%" value="<?php echo $profiency['no_sertifikat']?>">
                    </div>
                    <div class="form-group">
                        <label for="certificate" style="width:100%">Issued Date </label>
                        <input type="text" name="date_issue" id="date_issue" class="form-control" style="width:80%" 
                        value="<?php echo $profiency['date_issue']?>">
                    </div>
                    <div class="form-group">
                        <label for="certificate" style="width:100%">Issued Place </label>
                        <input type="text" name="place_issue" id="place_issue" class="form-control" style="width:80%" value="<?php echo $profiency['place_issue']?>">
                    </div>
                    <button class="btn btn-success" id="profiency-update-btn" type="button"> <span class="glyphicon glyphicon-floppy-disk"></span>&nbsp; Save </button>
    <button class="btn btn-primary " type="reset"> <span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp; Reset </button>
                    
                    
                </form>
            </div>
        
        </div><!-- Modal Body -->
        
    </div><!-- Modal Content -->
  </div><!-- Modal dialog -->
</div><!-- Modal -->

<script>

    $("#date_issue").datepicker({
        dateFormat:"yy-mm-dd",
        changeMonth:true,
        changeYear:true
        
    });
    
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