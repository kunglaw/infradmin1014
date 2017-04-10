
<div class="modal fade modal-resume" id="modal-form-upload-resume" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

  <div class="modal-dialog "><!-- large -->

    <div class="modal-content"> 

    	<div class="modal-header bg-primary" style="padding:-20px 0 -20px 0">

        	<h4> Form Upload Resume 

            <button type="button" class="close" data-dismiss="modal">

            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

            </h4>

            

        </div>

        

    	<div class="modal-body">

        	<div id="info_doc">
            </div>

            

            <div id="form-upload-resume">

            	<form role="form" class="" id="form-upload-file-resume" method="post" action="<?php echo base_url("seatizen/add_file_resume") ?>">

                
					<input type="hidden" name="id_user" value="<?=$pelaut_id?>" >
                    <div class="form-group">

                    	<label for="" style="display:block"> Resume Title </label>

                        <span>
                        	<span class="pull-left" style="width:60%;margin:0 10px 0 0;border:1px solid;min-height:30px"> 

                        	<span id="nama_file_resume"> </span> </span>

                          <!-- <input type="text" name="title" id="nama_file_resume" class="form-control pull-left" style="width:60%; margin:0 10px 0 0" > -->

                          <button class="btn btn-primary pull-left" id="browse-resume-btn" type="button">+ Browse </button>

                        </span>

                        <span class="clearfix"></span>

                        	Info : "Allowed file types : doc,docx,pdf" <br>

                        <!-- <span>file : <font id=""></font> </span> -->

                        <input type="file" value="" name="file_resume" id="file_resume" class="form-control" style="width:10%; display:none" >

                    </div>

                     <button class="btn btn-success" id="save-resume-upload" type="submit" > <span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;
                     	Upload
                     </button>
                     
                     	&nbsp;&nbsp;

    				<button class="btn btn-primary "> <span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp; Reset </button>

            	</form>

            </div>

        



        </div><!-- modal-body-->

    </div><!-- modal-content -->

  </div><!-- modal-dialog -->

</div><!-- modal -->

<script src="<?php echo infr_asset()."js/jquery.form.min.js"; ?>" type="text/javascript"></script>
<script type="text/javascript">

	$(document).ready(function(e) {
		
        $("#modal-form-upload-resume").modal({

			backdrop:"static",
			show:true	

		});

		var options = {
			
			target : "#info_doc",
  
			data:"x=1", 
  
			beforeSubmit:showRequest,
  
			success:showResponse

		 }

		 $("#form-upload-file-resume").ajaxForm(options);

    });

	

	$("#file_resume").change(function(){

		var pinp = $(this).val();

		$("#nama_file_resume").html(pinp);

	});

	

	$("#browse-resume-btn").click(function(){

		$("#file_resume").click();	

	});

	

	function showRequest(formData, jqForm, options) { 

		return true;

	}

	function showResponse(responseText, statusText, xhr, $form)  { 

		//$("#info").html(responseText);

	}

</script>