<script src ="<?php echo plugin_url() ."jquery-typeahead/dist/jquery.typeahead.min.js" ; ?>" ></script>
<link   href="<?php echo plugin_url() ."jquery-typeahead/dist/jquery.typeahead.min.css"; ?>" rel="stylesheet">

<script>

$(document).ready(function(e) {

	$("#post_btn").click(function() {



		var data = $("#post_form").serialize();

		

			$.ajax({

			   type: "POST",

			   url: "<?=base_url('vacantsea/insert_scrap_vacantsea') ?>",

			   data: $("#post_form").serialize(), // serializes the form's elements.

			   dataType:"json",

			   success: function(data)

			   {

				   if(data.status == "success")

				   {

					   $("form#post_form")[0].reset();

				   }

				   

				   	$("#info").html(data.msg);

				   //$('#post_form')[0].reset();

			   }

			 }); 

	});

	

	$("#get_id_department").change(function(){

				  

	  $.ajax({

		  url:"<?php echo base_url("index.php/rank/rankajax_bydept") ?>",

		  type: "POST",

		  data:"id_department=" + $(this).val(),

		  success: function(data) {

			  

			  $("#get_rank").html(data);

		  }	

	});

	

	

});

function validasi_salary(){

	var salary = document.forms['post_form']['salary'].value;

	var number = /^[0-9]+$/;

	if (!salary.match(number)) {

		alert("Salary harus angka");

		return false;

	};

}



});

</script>

<script src="<?=asset_url('js/validasi_angka.js');?>"></script>

<div id="info"></div>

<form role="form" id="post_form" class="post_form" method="post">

<div>

	<div class="col-sm-4"> 

    	<div class="form-group">

    		<label>Company *</label>

        	<input type="text" value="" name="company" id="company_name" class="form-control" autocomplete="off">

        </div>

    </div>

    <div class="col-sm-4">

    	<div class="form-group">

        	<div class=""> 

        	<label> Username *</label>

          	<input type="text" value="" name="username" id="username_val" class="form-control username_val" autocomplete="off">

            </div>

    	</div>

    </div>

    <div class="col-sm-4"> 

    	<div class="form-group">

    		<label> Contact Person </label>

            <input type="text" value="" name="contact_person" id="contact_person" class="form-control">

        </div>

    </div>

</div>
<div>   

    <div class="col-sm-4">

    	<div class="form-group">

        	<div class=""> 

        	<label> Website *</label>

          	<input type="text" value="" name="website" id="website_val" class="form-control website_val" autocomplete="off">

            </div>

    	</div>

    </div>  

    <div class="col-sm-4">

    	<div class="form-group">

        	<div class=""> 

        	<label> Email *</label>

          	<input type="email" value="" name="email" id="email_val" class="form-control email_val" autocomplete="off">

            </div>

    	</div>

    </div>

    <!-- <input type="hidden" value="" name="id" id="id_val"> --> 

    <div class="col-sm-4">

    	<div class="form-group">

        	<div class=""> 

        	<label> No Telp </label>

          	<input type="no_telp" value="" name="no_telp" id="no_telp_val" class="form-control no_telp_val" autocomplete="off">

            </div>

    	</div>

    </div>  

</div>
<div>
	<div class="col-sm-4">

    	<div class="form-group">

        	<div class=""> 

        	<label> Url Source </label>

          	<input type="url" value="" name="url_source" id="url_source" class="form-control " autocomplete="off">

            </div>

    	</div>

    </div>

</div>

<span class="clearfix"></span>

<hr>

<div>

    <div class="col-sm-4">

        <div class="form-group">

            <label>Title*</label>

            <input type="text" class="form-control" placeholder="vacantsea title" id="title" name="title" required/>

        </div>

        <div class="form-group">

            <label>Navigation Area</label>

            <input type="text" class="form-control" placeholder="ex:worldwide, pacific, etc" id="nav_area" name="nav_area"/>

        </div>

        <div class="form-group">

            <label>Vesel Type*</label>

            <select class="form-control" name="ship_type" id="ship_type">

                <option style="display:none" value="">-Select-</option>

                <!-- <option></option> -->

                <?php 

                    foreach ($type_ship as $key) {

                        echo "<option value='".$key["type_id"]."'>".$key["ship_type"]."</option>";

                    }

                ?>

            </select>

        </div>

        <div class="form-group">

            <label>Vessel Name</label>

            <input type="text" class="form-control" name="ship_name" id="ship_name">

            

        </div>

    

        <div class="form-group">

            <label>Detail*</label>

            <textarea class="form-control" placeholder="vacantsea detail" rows="3" id="detail" name="detail" required></textarea>

        </div>

        <div class="form-group">

            &nbsp;

        </div>

    </div><!-- /.col-sm-4-->

    

    <div class="col-sm-4">

         <div class="form-group">

            <label for="departement"> Departement* </label>

            <select class="form-control" id="get_id_department" name="department_id">

            <option style="display:none" value="">-Select-</option>

            <?php foreach($department as $row) { ?>

            <option value="<?php echo $row['department_id'] ?>"><?php echo $row['department'] ?></option>

            <?php } ?>

            </select>

        </div>

        <div class="form-group">

            <label for="rank">Rank*</label>

            <select class="form-control" name="rank_id" id="get_rank">

            <option selected="selected" value="">-Select-</option>

            <!--AJAX "LIST_RANK.PHP" -->

            </select>

        </div>

        <div class="form-group">

        <label>Salary</label>

            <div  class="row">

            <div class="col-sm-3">

                <select class="form-control" name="sallary_curr" id="sallary_curr">

                <option style="display:none" value="">-</option>

                <option value="IDR">IDR</option>

                <option value="SGD">SGD</option>

                <option value="USD">USD</option>

                <option value="EUR">EUR</option>

                </select>

            </div>

            <div class="col-sm-6">

                <input type="text" class="form-control" placeholder="must number" id="salary" name="salary" onkeydown="return numbersonly(this, event);" />

            </div>

            <div class="col-sm-3" style="margin-bottom:-20px !important">

                <select class="form-control" id="sal_type" name="salary_type">

                    <option value="/day">/ Day</option>

                    <option value="/month">/ Month</option>

                    <option value="/year">/ Year</option>

                </select>

            </div>

            </div>

        </div>

        <div class="form-group">

            <label>Contract Dynamics</label>

            <input type="text" class="form-control" placeholder="" id="contract_dyn" name="contract_dyn"/>

        </div>

        <div class="form-group">

            <label>Requested Certificate</label>

            <!-- <input type="text" class="form-control" placeholder="" id="req_cert" name="req_cert"/> -->

            <textarea class="form-control" id="req_cert" name="req_cert" rows="3"></textarea>

        </div>

        <div class="form-group">

            &nbsp;

        </div>

    </div><!-- /.col-sm-4-->

    

    <div class="col-sm-4">

        <div class="form-group">

            <label>Benefits</label>

            <input type="text" class="form-control"  id="benefits" name="benefits"/>

        </div>

        

        <div class="form-group">

            <label>Requested COC</label>

            <!-- <input type="text" class="form-control" placeholder="" id="req_coc" name="req_coc"/> -->

            <textarea class="form-control" id="req_coc" name="req_coc" rows="3"></textarea>

        </div>

        <div class="form-group">

            <label> Nationality </label>

            <select class="form-control" id="nationality" name="nationality_id">

            <option style="display:none" value="">-Select-</option>

            <?php foreach($nationality as $row) { ?>

            <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>

            <?php } ?>

            </select>

        </div>

        <div class="form-group">

            <label>Expired Date</label>

            <div class="input-group">

            <div class="input-group-addon">

            <i class="fa fa-calendar"></i>

            </div>

            <input type="text" class="form-control pull-right" id="expired_date" name="expired_date"/>

            </div><!-- /.input group -->

        </div>

        <div class="form-group">

            <label>Minimum Experience</label>

            <!-- <textarea class="form-control" id="experience" name="experience" rows="3"></textarea> -->

            <input type="text" class="form-control" id="experience" name="experience"/>

        </div>

      

            <div class="form-group pull-right">

                <button type="button" class="btn btn-default" onClick="javascript:reseto()"><i class="glyphicon glyphicon-repeat"></i> Reset</button>

                <!-- <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-search-plus"></i> Preview</button> -->

                <button type="button" class="btn btn-success" id="post_btn"><i class="glyphicon glyphicon-plus"></i> Add Vacantsea</button>

            </div>

        

            

    </div><!-- /.col-sm-4-->

</div>



<!-- <div class="clearfix">

    <?php $username = $this->session->userdata("username_company"); ?>

    <a href="<?=base_url($username.'/hire_crew/applicant');?>"><i class="glyphicon glyphicon-chevron-left"></i> Go to applicant list</a>

</div> -->

</form>



<script type="text/javascript">



function reseto()

{

	$("form#post_form")[0].reset();	

}



$(document).ready(function(e) {

	

	$("#expired_date").datepicker({

        dateFormat:"yy-mm-dd",

        changeMonth:true,

        changeYear:true

        

    });

	

	/* $('input#email_val').typeahead({

		order: "asc",

		

        source: function (query, process) {

            return $.get('<?=base_url("vacantsea/get_company_byemail");?>?email_val=' + query, function (data) {

                return process(data.email);

            });

        },

		/*source: {

			groupName: {

				// Array of Objects / Strings

				ajax:{

					url: "<?=base_url("vacantsea/get_company_byemail");?>",

					type:"POST",

					

						

				}

			}

		},

		onInit: function (node) {

            console.log('Typeahead Initiated on ' + node.selector);

        }

	});*/

	

	/*$("input#company_name").autocomplete({

	  

      /* source: function(request,response)

	  {

		  $.post("<?=base_url("vacantsea/get_company_byemail");?>", request, response);

	  },*/

	  /*source:"<?=base_url("vacantsea/get_company_byname");?>",

      minLength: 2,

	  focus: function( event, ui ) {

        $( "input#company_name" ).val( ui.item.nama_perusahaan );

        return false;

      },

      select: function( event, ui ) {

        

		if(ui.item != "")

		{

			$("input#company_name").val(ui.item.nama_perusahaan);

			$("input#contact_person").val(ui.item.contact_person);

			$("input#email_val").val( ui.item.email );

			$("input#username_val").val( ui.item.username );

			$("input#id_val").val(ui.item.id_perusahaan);

			

		}else

		{

			$("input#company_name").val("");

			$("input#contact_person").val("");

			$("input#email_val").val("");

			$("input#username_val").val("");

			$("input#id_val").val("");

		}

		

		return false;

      },*/

	  

	  // ISI LABEL, INGAATT!! LABEEELL!!!

    /*}).autocomplete( "instance" )._renderItem = function( ul, item ) {

      return $( "<li>" )

        .append( "<div>" + item.nama_perusahaan + "</div>" )

        .appendTo( ul );

    };*/

	

	/*$( "input#email_val" ).autocomplete({

	  

      /* source: function(request,response)

	  {

		  $.post("<?=base_url("vacantsea/get_company_byemail");?>", request, response);

	  },*/

	 /* source:"<?=base_url("vacantsea/get_company_byemail");?>",

      minLength: 2,

	  focus: function( event, ui ) {

		  

        if(ui.item != "")

		{

			$("input#company_name").val(ui.item.nama_perusahaan);

			$("input#contact_person").val(ui.item.contact_person);

			$("input#email_val").val( ui.item.email );

			$("input#username_val").val(ui.item.username);

			$("input#id_val").val(ui.item.id_perusahaan);

			

		}

		else

		{

			$("input#company_name").val("");

			$("input#contact_person").val("");

			$("input#email_val").val("");

			$("input#username_val").val("");

			$("input#id_val").val("");

		}

		

        return false;

      },

      select: function( event, ui ) {

        

		if(ui.item != "")

		{

			$("input#company_name").val(ui.item.nama_perusahaan);

			$("input#contact_person").val(ui.item.contact_person);

			$("input#email_val").val( ui.item.email );

			$("input#username_val").val(ui.item.username);

			$("input#id_val").val(ui.item.id_perusahaan);

			

		}else

		{

			$("input#company_name").val("");

			$("input#contact_person").val("");

			$("input#email_val").val("");

			$("input#username_val").val("");

			$("input#id_val").val("");

		}

		return false;

      },

	  change:function( event, ui ) {

        

		if(ui.item != "")

		{

			$("input#company_name").val(ui.item.nama_perusahaan);

			$("input#contact_person").val(ui.item.contact_person);

			$("input#email_val").val( ui.item.email );

			$("input#username_val").val(ui.item.username);

			$("input#id_val").val(ui.item.id_perusahaan);

			

		}else

		{

			$("input#company_name").val("");

			$("input#contact_person").val("");

			$("input#email_val").val("");

			$("input#username_val").val("");

			$("input#id_val").val("");

		}

		return false;

      }*/

	  

	  // ISI LABEL, INGAATT!! LABEEELL!!!

    /*}).autocomplete( "instance" )._renderItem = function( ul, item ) {

      return $( "<li>" )

        .append( "<div>" + item.email + "</div>" )

        .appendTo( ul );

    };*/

	

	/* $("input#email_val").autocomplete({

	  

	   select: function (event, ui) {

		   $("input#email_val").val(ui.item.email);

		   return false;

	   },

	  source: function( request, response ) {

		  

		  $.ajax({

			  dataType:"JSON",

			  type : 'POST',

			  url  : '<?=base_url("vacantsea/get_company_byemail");?>',

			  data : "email="+request.term,

			  success: function(data) {	  

				  

				   

				  

				  $('input.suggest-user').removeClass('ui-autocomplete-loading');  

				  // hide loading image

  

				  response( $.map( data, function(item) {

					 

				  }));

			  },

			  error: function(err) {

				  $('input.suggest-user').removeClass('ui-autocomplete-loading'); 

				  

			  }

		  });

	  	 

	  }, 

	  minLength: 3

	 

	});

	

	$( "input.suggest-user" ).autocomplete({

		

	  source: function( request, response ) {

		  $.ajax({

			  dataType: "json",

			  type : 'Get',

			  url: 'yourURL',

			  success: function(data) {

				  $('input.suggest-user').removeClass('ui-autocomplete-loading');  

				  // hide loading image

  

				  response( $.map( data, function(item) {

					  // your operation on data

				  }));

			  },

			  error: function(data) {

				  $('input.suggest-user').removeClass('ui-autocomplete-loading');  

			  }

		  });

	  },

	  minLength: 3,

	  open: function() {},

	  close: function() {},

	  focus: function(event,ui) {},

	  select: function(event, ui) {}

	  

    }); */

	

});



    

</script>