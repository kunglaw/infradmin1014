<!-- Make sure the path to CKEditor is correct. -->
<!-- <script src="http://www.informasea.com/informasea_assets/plugin/ckeditor/ckeditor.js"></script> -->
 <script>
	// Replace the <textarea id="editor1"> with a CKEditor
	// instance, using default configuration.
	// CKEDITOR.replace( 'email_content' );
</script>

<div class="modal fade" id="send_email_form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    
      <form method="post" action="<?=base_url("agentsea/send_email_process")?>" role="form" id="send_mail_frm" >
        <div class="modal-header bg-header-modal">
          <button type="button" class="close" onClick="" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          
          <h4 class="modal-title"> Form Send Email </h4>
          
        </div>
        <div class="modal-body">
            
            <div class="fsa_info"></div>
            
        	<div class="form-group">
            	<label for=""> Company Name </label>
                <span class="clearfix">
                <input type="text" class="form-control pull-left" style="width:80%" name="company_name" id="company_name" placeholder="">
               
                </span>
            </div>
            
            <div class="form-group">
            	<label for=""> Contact Person </label>
                <span class="clearfix">
                <input type="text" class="form-control pull-left" style="width:80%" name="contact_person" id="contact_person" placeholder="">
  
                </span>
            </div>
            
            <div class="form-group">
            	<label> Email </label>
                <input type="email" name="email" class="form-control" placeholder="email" style="width:80%" id="email">
            </div>
            
            <div class="form-group">
            	<div class="col-sm-offset-2 col-sm-10">
                  <div class="radio">
                    <label>
                      <input type="checkbox" name="type" > 
                    </label>
                  </div>
                </div>
            </div>
            
            <div class="form-group">
            	<label> Content </label>
                <?php /*tambahkan CKE Editor*/ ?>
                <textarea class="form-control" style="width:100%" rows="10" name="email_content" id="email_content"></textarea>
            </div>
            
            <span class="clearfix"></span>
                                    
            <div class="pull-left">
                <label> Footer </label>
                <div class="radio">
                  
                  <label>
                    <input type="radio" name="is_info" id="is_info" value="1" checked>
                    With Footer
                  </label>
                  &nbsp;
                  <label>
                    <input type="radio" name="is_info" id="is_info" value="0" >
                    Without Footer
                  </label>
                  
                </div>
            </div>
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" onClick="">Close</button>
          <button type="button" class="btn btn-success" id="save-change">Send Email</button>
        </div>
      </form>
      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

<script>

	function submit_send_email()
	{
		$.ajax({
			type:"POST",
			url:$("#send_mail_frm").attr("action"),
			data:$("#send_mail_frm").serialize(),
			dataType:"json",
			success: function(data)
			{
				$(".fsa_info").html(data.notification);
				$("form").reset();
			}
		});
			
	}
	
	$(document).ready(function(e) {
       
	    $('#send_email_form').modal({
		  show:true,
		  backdrop:"static"
		}); 
		
		$("#save-change").click(function(){
			
			submit_send_email();
			
		});
		
    });

</script>