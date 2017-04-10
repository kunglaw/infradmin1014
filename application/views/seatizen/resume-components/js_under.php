<script>

 $(document).ready(function(e) {

	// alert('hai');
	//get_modal("form-profile","#profile-btn");

	$("#profile-btn").click(function(e) { // edit profile

		beforeResume();
		var type_modal = $(this).attr("modal"); 
		get_modal(type_modal,"#profile-btn");

		

	});

	

	$("#kepelautan-btn").click(function(e) { // kepelautan

		beforeResume();
		var type_modal = $(this).attr("modal"); 

		get_modal(type_modal,"#kepelautan-btn");

	});
	
	$("#describe-btn").click(function(e){

		beforeResume();

		var type_modal = $(this).attr("modal");
		get_modal(type_modal,"#describe-btn");

	});
	
	$("#cover-letter-btn").click(function(e){

		beforeResume();

		var type_modal = $(this).attr("modal");
		get_modal(type_modal,"#cover-letter-btn");

	});


	$("#coc-btn").click(function(e) { // competency

	 	beforeResume();
		var type_modal = $(this).attr("modal");
		get_modal(type_modal,"#coc-btn");

	});



	 $("#visa_btn").click(function(e){

	 	beforeResume();

	 	var type_modal = $(this).attr("modal");

	 	get_modal(type_modal,"#visa_btn");

	 })

	

	 $("#proficiency-btn").click(function(e) { //proficiency

		beforeResume();

		var type_modal = $(this).attr("modal"); 

		get_modal(type_modal,"#proficiency-btn");

	});

	

	 $("#experience-btn").click(function(e) { //experience 

	 	beforeResume();

		var type_modal = $(this).attr("modal"); 

		get_modal(type_modal,"#experience-btn");

	});

	

	$("#document-btn").click(function(e){

		beforeResume();

		var type_modal = $(this).attr("modal");

		get_modal(type_modal,"#document-btn");
	

	});

	

	$("#medical-btn").click(function(e){
		//alert("sasas");

		beforeResume();
		var type_modal = $(this).attr("modal");
		get_modal(type_modal,"#medical-btn");

	});


	/* update zone */


	$(".exp-update-btn").click(function(e){ // experience update

		beforeResume();
		var type_modal = $(this).attr("modal");
		get_modal(type_modal,".exp-update-btn");

	});

	$("#resume-upload-btn").click(function(e) { //experience 

		var type_modal = $(this).attr("modal"); 
		get_modal(type_modal,"#resume-upload-btn");


	});

});

</script>