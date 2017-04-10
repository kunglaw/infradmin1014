

<?php // js_top, profile, module seaman ?>

<?php // INGA2 !! FUNCTION ITU HARUSNYA ADA DIATAS ?>

<!-- load js_top profile  -->

<!-- 
<script type="text/javascript" src="<?php echo asset_url('plugin/vanillabox/jquery.vanillabox.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset_url('plugin/vanillabox/jquery.vanillabox-0.1.7.min.js') ?>"></script>
<script type="text/javascript" src="<?=asset_url("js/script.js")?>" ></script>
<script type="text/javascript" src="<?=asset_url("plugins/slick/slick.min.js")?>" ></script>

<!-- resume --

<script src="<?php echo asset_url("js/jquery.form.min.js");?>"></script>

<link href="<?php echo asset_url("css/jquery.dataTables.css") ?>" type="text/css" rel="stylesheet" />

 -->

<script>

	 function get_modal(type_modal,id_update)
	 {

	   	// alert(id_update);

	   	var id_pelautnya = "<?php echo $this->uri->segment(4) ?>";
	   	var datanya = "x=1&modal="+type_modal+"&id_update="+id_update+"&pelaut_id="+id_pelautnya;
	  	// alert(datanya);

	 
		$.ajax({

			type:"POST",
			data:datanya,
			url:"<?php echo base_url("seatizen/modal"); ?>",
			success: function(data){
				
				
				$(".tmp_modal").html(data);	

			}

		});

	 }

</script>



<script>



	function beforeResume()
	{

		$("#sticky.sticky").removeAttr("z-index");

		$("#sticky.sticky").css("z-index","0 !important");

		//$(".modal-backdrop").css("z-index","0 !important");

	}

</script>



<!-- document function -->

<script type="text/javascript">

  function update_document(id_document){

	  //alert("id_document:"+id_document)

	  beforeResume();

	  var type_modal = "form-update-document";

	  get_modal(type_modal,id_document);

  }

 
  function delete_document(id_document){


	  beforeResume();

	  var type_modal = "delete-document-modal";

	  get_modal(type_modal,id_document);

	  

  }

  function update_medical(id_document){



  	beforeResume();

  	//alert(id_document);

  	//alert('aku disini');

  	var type_modal = "form-update-medical";

  	get_modal(type_modal,id_document);

  }

</script>



<!-- coc endorsement -->

<script>

  function edit_cocend(id_coc){

	beforeResume();

	type_modal = "form-update-competency";

	get_modal(type_modal,id_coc);

	//e.preventDefault();

  }

  function delete_cocend(id_coc){

	beforeResume();

	var type_modal = "delete-competency-modal";

	get_modal(type_modal,id_coc);

	//e.preventDefault();

  }

  

</script>



<!-- function proficiency-->

<script>

	function update_proficiency(id_proficiency){
		
		beforeResume();

		var type_modal = "form-update-proficiency";

		get_modal(type_modal,id_proficiency);

	};

	function delete_proficiency(id_proficiency){

		//alert("id_proficiency:"+id_proficiency)

		beforeResume();

		var type_modal = "delete-proficiency-modal";

		get_modal(type_modal,id_proficiency);

		

	};

</script>



<script>

	function update_experience(experience_id){

		

		beforeResume();

		var type_modal = "form-update-experience";

		get_modal(type_modal,experience_id);

		

	}

	function delete_experience(experience_id){

		beforeResume();

		var type_modal = "delete-experience-modal";

		get_modal(type_modal,experience_id);

		

	}

</script>



<script>

	function update_visa(document_id){

		beforeResume();

		var type_modal = "form-update-visa";

		get_modal(type_modal,document_id);

	}



	function delete_visa(document_id){

		beforeResume();

		var type_modal = "delete-visa-modal";

		get_modal(type_modal,document_id);

	}



	function download_resume(resume_id){

		$.ajax({

			type:"POST",

			data:"id_resume_file="+resume_id,

			url:"<?php echo base_url('seaman/resume/download_resume') ?>",

			success:function(data){

				

			}

		})
	}

	function delete_resume(resume_id){


		var type_modal = "modal-delete-resume-upload";

		get_modal(type_modal,resume_id);

		

	}



</script>