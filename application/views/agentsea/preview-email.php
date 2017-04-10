<!-- Make sure the path to CKEditor is correct. -->
<!-- <script src="http://www.informasea.com/informasea_assets/plugin/ckeditor/ckeditor.js"></script> -->
 <script>
	// Replace the <textarea id="editor1"> with a CKEditor
	// instance, using default configuration.
	// CKEDITOR.replace( 'email_content' );
</script>

<style>
	.modal .modal-body {
		max-height: 420px;
		
		overflow-y: auto;
	}
</style>

<div class="modal fade" id="preview-email" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
   
        <div class="modal-header bg-header-modal">
          <button type="button" class="close" onClick="" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          
          <h4 class="modal-title"> Preview <?=$title?> </h4>
          
        </div>
        <div class="modal-body">
            
           <?=$template_email?>
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" onClick="">Close</button>
         
        </div>
      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

<script>

	
	$(document).ready(function(e) {
       
	    $('#preview-email').modal({
		  show:true,
		  backdrop:"static"
		}); 
		
		
		
    });

</script>