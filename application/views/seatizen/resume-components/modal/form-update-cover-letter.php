 <?php
 	$profile = $resume["profile"]; 
	$pelaut  = $resume["pelaut"];
 ?>
 <script src="<?=infr_url("informasea_assets/plugin/tinymce/tinymce.min.js")?>"></script>

  <script>

  	   tinymce.init({ selector:'#cover_letter',

  			

			theme: "modern",

			plugins: [

				"advlist autolink lists link image charmap print preview hr anchor pagebreak",

				"searchreplace wordcount visualblocks visualchars code fullscreen",

				"insertdatetime media nonbreaking save table contextmenu directionality",

				"emoticons template paste textcolor colorpicker textpattern imagetools"

			],

			toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",

			toolbar2: "print preview media | forecolor backcolor emoticons",

			image_advtab: true,

			templates: [

				{title: 'Test template 1', content: 'Test 1'},

				{title: 'Test template 2', content: 'Test 2'}

			]



			

	   });</script>

 

<script>



	function update_cover_letter_process()

	{
		
		alert("save");
		
		tinymce.init({ 

			selector:'#cover_letter'

			

			//plugins: 'code',

  			//toolbar: 'code',

			//menubar: 'file edit insert view format table tools'

		});

		 //CKEDITOR.replace('cover_letter');

		/*for (instance in CKEDITOR.instances) {

			CKEDITOR.instances[instance].updateElement();

		}*/

		//var aaa = CKEDITOR.instances.cover_letter.getData();

		var formData = $("#form-cover-letter form").serialize();

		var cover_letter = tinymce.get('cover_letter').getContent();

		//alert("cover_letter="+cover_letter);

		$.ajax({

			

			type	 : "POST",

			url 	  : '<?php echo base_url("seatizen/update_cover_letter_process"); ?>',

			data	 : "cover_letter="+cover_letter,

			dataType : "JSON",

			success  : function(data){

				//alert("fine..");
				alert(data.message);
				//$("#info-cl").html(data.message);
				


			}

			

		});

	}



</script>

<div class="modal fade modal-form-update-cover-letter modal-resume" id="" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

  <div class="modal-dialog modal-lg"><!-- large -->

    <div class="modal-content"> 

    	<div class="modal-header bg-primary" style="padding:-20px 0 -20px 0">

        	<h4> Edit Cover Letter <!-- Certificate of cover-letter --> <button type="button" id="close-modal-btn" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></h4>

        </div>

         

    	<div class="modal-body">
			
        	

            <div id="info-cl">

            

            </div>

            <div id="form-cover-letter">

            	<form role="form" class="" method="post">

                

                	
					<input type="hidden" name="pelaut_id" id="pelaut_id" value="<?=$pelaut["pelaut_id"]?>" >
                    <div class="form-group">

                    	<label> Cover Letter </label>

                       	

                        <textarea class="form-control" name="cover_letter" id="cover_letter" rows="10" style=""><?=htmlspecialchars_decode(html_entity_decode($profile["cover_letter"]))?></textarea>

                    </div>

                        <button class="btn btn-danger pull-right" data-dismiss="modal"> <span class="glyphicon glyphicon-remove-circle"></span>&nbsp; 

                        <b> Cancel </b> </button>

                        

                        <span class="pull-right">&nbsp;</span>

                        <button class="btn btn-success pull-right" id="cover-letter-update-btn" type="button" data-loading-text="Loading..." onClick="update_cover_letter_process()"> 

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

	

	$(document).ready(function(e) {

		

		

		$(".modal-form-update-cover-letter").modal({

			backdrop:"static",

			show:true	

		});

		

	

	});

	

	$(document).ready(function(e) {

        

		

		/*CKEDITOR.editorConfig = function( config ) {

			config.toolbarGroups = [

				{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },

				{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },

				{ name: 'links', groups: [ 'links' ] },

				{ name: 'insert', groups: [ 'insert' ] },

				{ name: 'forms', groups: [ 'forms' ] },

				{ name: 'tools', groups: [ 'tools' ] },

				{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },

				{ name: 'others', groups: [ 'others' ] },

				'/',

				{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },

				{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },

				{ name: 'styles', groups: [ 'styles' ] },

				{ name: 'colors', groups: [ 'colors' ] },

				{ name: 'about', groups: [ 'about' ] }

			];

		

			config.removeButtons = 'Underline,Subscript,Superscript,Image,SpecialChar,About';

		};*/

		

		

		

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

