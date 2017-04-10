<?php
/**
 * Created by PhpStorm.
 * User: pulung
 * Date: 29/10/14
 * Time: 13:00
 */
?>
<?php $this->load->view("element/header"); ?>

	
    <div id="agentsea-modal"></div>
    <div id="page-wrapper">
    
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header">
                    <span>
                        <a href="<?php echo base_url(); ?>send_email" style="color: #3093E4;">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                    </span>
                    	
                        Send Email
                    
                </h1>
                <span style="color:red"> * press Ctrl+Enter to send multiple Email in "Company Name" , "Contact Person" , "Email" field   </span>
            </div>
            <!-- /.col-md-12 -->
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">

                               <form method="post" action="<?=base_url("agentsea/send_email_process")?>" role="form" id="send_mail_frm" >
        						 <div class="fsa_info"></div>
                                 
                                  <span class="clearfix"></span>
                                  
                                  <div class="preview-emailnya">
                                  	
                                  </div>
                                  
                                  <span class="clearfix"></span>
                                  
                                 
                                  <div class="form-emailnya"> 
                                    <div class="form-group">
                                          <label> From </label>
                                          <select name="email_from" id="email_from" onchange="validate_pass()" style="width:80%" class="form-control">
                                            <option selected>info@informasea.com</option>
                                            <option >rifalqori@informasea.com</option>
                                            <option >rini@informasea.com</option>
                                            <option >alhusna901@informasea.com</option>
                                            <option>dimas@informasea.com</option>
                                            <option >radityapratama@informasea.com</option>
                                            <option >markus@informasea.com</option>
                                            <option >soesetyo@informasea.com</option>
                                            
                                          </select>
                                      </div>
                                      <div class="form-group" id="pass_email">
                                        <label for=""> Password Email </label>
                                        <!-- <span class="clearfix"> -->&nbsp;&nbsp;&nbsp;
                                        <input type="password" style="width: 50%; display:inline;" class="form-control" name="password_email" id="password_email" placeholder="please insert email password">
                                       
                                        <!-- </span> -->
                                    </div>
                                    <span class="clearfix"></span>
                                    <!-- <div id="form-email-valid"> -->
                                    <!-- <div class="form-group">
                                        <label> Email </label>
                                        <span class="clearfix">
                                        <input type="radio" name="type_emailnya" value="single" class="radio-type" style="display: inline" checked> Single
                                        <input type="radio" name="type_emailnya" value="multiple" class="radio-type" style="display: inline"> Multiple
                                       
                                        </span>
                                    </div> -->
                                    <div class="form-group">
                                        <label for="multiple-tags"> Company Name </label>
                                        <span class="clearfix">
                                        <input type="text" class="form-control pull-left control-multiple" style="width:80%" name="company_name" id="company_name" placeholder="Company Name" data-role="tagsinput">
                                       
                                        </span>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="multiple-tags"> Contact Person </label>
                                        <span class="clearfix">
                                        <input type="text" class="form-control pull-left control-multiple" style="width:80%" name="contact_person" id="contact_person" placeholder="Contact Person" data-role="tagsinput">
                                        </span>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="multiple-tags"> Email </label>
                                        <span class="clearfix"></span>
                                        <input type="email" name="email" class="form-control control-multiple" placeholder="email" style="width:100%" id="email" data-role="tagsinput">
                                    </div>
                                    
                                    <div class="form-group">
                                    	<label for="multiple-tags"> Username </label>
                                        <input type="text" class="form-control control-multiple" name="username" id="username" placeholder="username" style="width:80%" data-role="tagsinput">   
                                    </div>
                                    
                                    <div class="form-group">
                                    	<label> Type Email </label>
                                        <span class="clearfix"></span>
                                        <div class="col-md-2">
                                          <div class="radio">
                                            <label>
                                              <input type="radio" name="type" value="1" > 
                                              Create Vacantsea for free
                                            </label>
                                          </div>
                                        </div>
                                        
                                        <div class="col-md-2">
                                          <div class="radio">
                                            <label>
                                              <input type="radio" name="type" value="2" > 
                                              Demo dan Free Trial Dashboard 
                                            </label>
                                          </div>
                                        </div>
                                        
                                        <div class="col-md-2">
                                          <div class="radio">
                                            <label>
                                              <input type="radio" name="type" value="3" > 
                                              Demo dan Free Trial Alpha
                                            </label>
                                          </div>
                                        </div>
                                        
                                        <div class="col-md-2">
                                          <div class="radio">
                                            <label>
                                              <input type="radio" name="type" value="4" > 
                                              Demo dan Activate
                                            </label>
                                          </div>
                                        </div>
                                        
                                        <div class="col-md-2">
                                          <div class="radio">
                                            <label>
                                              <input type="radio" name="type" value="5" > 
                                              Seatizen List
                                            </label>
                                          </div>
                                        </div>
                                        
                                        <span class="clearfix"></span>
                                    </div>
                                    <div class="form-group pull-left">
                                        <label for=""> Browse Image to Content </label>
                                        <span class="clearfix">
                                        <input type="file" class="pull-left" name="browse_img" id="browse_img" placeholder="">
                          
                                        </span>
                                    </div>
                                    <span class="clearfix"></span>
                                    <!-- Rank -->
                                    <div id="select_rank">
                                    <div class="form-group">
                                          <label style="width: 20%"> Vessel Type </label>
                                            <select name="vessel_type" id="vessel_type" class="form-control" style="width: 50%; display:inline;">
                                            <option value="" selected >- Please select Vessel Type -</option>
                                              <?php
                 
                          foreach($ship_type as $row)
                          {
                            
                        ?>
                          <option value="<?php echo $row['type_id']; ?>"><?php echo $row['ship_type']; ?></option>
                        <?php
                          }
                        ?>
                                            </select>
                                        </div>
                                    	<div class="form-group">
                                        	<label style="width: 20%"> Department </label>
                                            <select class="form-control" name="department" id="department" style="width: 50%; display:inline;" 
                                            >
											<option value="" selected >
                                            - Please select Department -</option>
											<?php
                                                
                                                foreach($department as $row){
                                                    
                                                   
                                            ?>
                                                <option value="<?php echo $row['department_id']; ?>" <?php echo $sd ?>><?php echo $row['department']; ?></option>
                                            <?php
                                                }
                                            ?>
                                            </select>
                                            <script>
											
											  $("#department").change(function(e)
											  { 
												  var department_id = $(this).val(); 
												
												  get_rank(department_id);
												  
											  });
			  
											</script>
                                        </div>
                                        
                                    	<div class="form-group">
                                        	<label style="width: 20%"> Rank </label>
                                            <select name="rank" id="rank" class="form-control" style="width: 50%; display:inline;">
                                            	<?php
                 
													foreach($rank as $row)
													{
														
												?>
													<option value="<?php echo $row['rank_id']; ?>"
                                                    <?php echo $sr ?>><?php echo $row['rank']; ?></option>
												<?php
													}
												?>
                                            </select>
                                        </div>
                                    </div> 
                                    <div class="form-group">
                                        <label> Content </label>
                                        <?php /*tambahkan CKE Editor*/ ?>
                                        <textarea class="form-control" style="width:100%" rows="10" name="email_content" id="email_content"></textarea>
                                    </div>
                                    
                                    <span class="clearfix"></span>
                                    
                                    <!-- <div class="pull-left">
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
                                    </div> -->
                                    
                                    <span class="clearfix"></span>
                                    
                                    <input type="hidden" name="list_email" id="list_email">
                                    <input type="hidden" name="message" id="message" value="">
                                 	
                                    <button type="reset" id="reset-btn" class="btn btn-default" onClick="re_reseto()">Reset</button>
                                    <button class="btn btn-primary" id="preview-email" type="button" onClick="preview_email()"> Preview Email </button>
                                    
                                  <!-- </div> -->
                                </div>
                                  
                                   <button type="button" class="btn btn-default" id="back-btn" onClick="reseto()" >Back</button>
                                   <button type="button" class="btn btn-success" id="save-change" >Send Email</button>
                              </form>

                            </div>
                        </div>

                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-md-12 -->
        </div>
        <!-- /.row -->
       
        <!-- ======================================================= Vessel List ==================================== -->
        
        <!-- DataTables CSS -->
        <link href="<?php echo bower_url(); ?>datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

        <!-- DataTables Responsive CSS -->
        <link href="<?php echo bower_url(); ?>datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">

        

    </div>
    <!-- /#page-wrapper -->

    <?php
    //$modal_delete_data = array();
    //$modal_delete_data["table_name"] = $delete_table_name;
    //$this->load->view("modal/delete_confirmation", $modal_delete_data);
    ?>
	<script src="<?php echo plugin_url() ?>ckeditor/ckeditor.js"></script>
    <script src="<?php echo plugin_url() ."tags_input/"; ?>bootstrap-tagsinput.min.js"></script>
	 <script>
        /* Replace the <textarea id="editor1"> with a CKEditor
        instance, using default configuration. */
        CKEDITOR.replace( 'email_content' );
    </script>
	<script>
	// $(".radio-type").change(function () {
 //    var value = $(this).val();
 //    if(value == "multiple") {
 //      // $("label[for=multiple-tags]");
 //      // var jsonnya = JSON.stringify($("#contact_person").prev("label[]"));
 //      // alert(jsonnya);
 //      $(".control-multiple").attr("data-role", "tagsinput").prev("input").append("<div class='bootstrap-tagsinput'><input type='text' size='14'></div>");
 //    }
 //    else {
 //      // $("label[for=multiple-tags]").next().children("p").remove();
 //      $(".control-multiple").removeAttr("data-role").prev("input").children("div").remove();
 //    }
 //  })
	function get_rank(department_id)
	{
		$.ajax({
			
			type:"POST",
			url:"<?php echo base_url("seatizen/get_rank"); ?>",
			data:"department_id="+department_id,
			success: function(data)
			{
				$("#rank").html(data);
			}
			
		});
	}
	
	var department_id = $("#department").val(); 
		
    get_rank(department_id); 
	$("#select_rank").hide();
	
	$("input[type=radio]").change(function(){
		
		// body...
		var typenya = $(this).val();
		
		//alert(typenya);
		
		
		if(typenya == 5) 
		{
			$("#select_rank").show('fast'); 
			
		}
		else 
		{
			
			$("#select_rank").hide('fast'); 
			
		}	
		
	});
	
    $('#pass_email').hide();
        var email, pass;
	  function validate_pass() {
          // body...
          email = $("#email_from").val();
          if(email != "info@informasea.com")
          {
            $("#pass_email").show('fast').attr('placeholder', 'please insert email password from '+email);
            // $('#form-email-valid').find('input, textarea, button').attr('disabled', true);
          }
          else {
            $("#pass_email").hide('fast').attr('placeholder', '');
            // $('#form-email-valid').find('input, textarea, button').attr('disabled', false);
        }
      }

      // function cek_email_pass(){
      //   pass = $("#password_email").val();
      //   pass = btoa(pass); //encrypt password

      //   $.ajax({
      //       type: "POST",
      //       url: "<?php echo base_url() ?>agentsea/validate_email",
      //       data: "email="+email+"&pass="+pass,
      //       success:function(output){
      //           alert(output);
      //       }
      //   });
      // }
	  $("#show-preview-mail").click(function(){
		 
		  //var type_email = $("input[type=radio]:checked").val();
		  //alert(type_email);
		  
		   var ec = CKEDITOR.instances.email_content.getData(); // CKEDITOR.instances.editor1.getData();
				 $("#message").val(ec);
		  
		  list_template();	
	  });
	  
	  function reseto()
	  {
      /*container*/
		  $(".preview-emailnya").html("").hide();
		
  		$("#save-change").hide();  
  		$("#preview-email").show(); /*button*/
  		
  		// $(".preview-emailnya");
  		$(".form-emailnya").show();
  		
  		$("#reset-btn").show();
  		$("#back-btn").hide();
	  }
	  
	  // back button
	  function re_reseto()
	  {
		  // alert("re_reseto");
		 $(".fsa-info").html("");
		 $(".fsa-info").hide();
		 
		 $(".preview-emailnya").html("");
		 
		 // alert("re_reseto 2");
		 
		 $("#save-change").show();  
		 $("#preview-email").hide();
		
		// alert("re_reseto 3");
		
 		$(".preview-emailnya").show();
		$(".form-emailnya").hide(); 
		
		// alert("re_reseto 4");
		
		$("#reset-btn").hide();
		$("#back-btn").show();
		
		// alert("re_reseto 5");
		
		$(".alert-danger").alert('close');
	  }
	  
	  function list_template()
	  {
		  var type_email = $("input[type=radio]:checked").val();
		  //alert(type_email);	
		  
		  $.ajax({
			  
			  type:"POST",
			  url:"<?=base_url("send_email/preview_type")?>",
			  data:$("#send_mail_frm").serialize(),
			  dataType:"json",
			  error:function(err)
			  {
				  alert(err.toSource());
			  },
			  success: function(res)
			  {
				
				  $("#form-emailnya").hide("fast");
				  $(".preview-emailnya").show("fast");
				  $(".btn-panel-email").show("fast");
				  // reseto();
				  
				  if(res.val == "success")
				  {
					  $("#save-change").show();
					  $(".preview-emailnya").html(res.success);
				  }
				  else
				  {
					  $("#save-change").hide();
					  $(".preview-emailnya").html(res.error);
				  }
			  }
			  
		  })
	  }
	  
	  function submit_send_email()
	  {
        // alert($("#send_mail_frm").serialize());
        var formData = new FormData($("#send_mail_frm")[0]);
		  $.ajax({
			  type:"POST",
			  url:$("#send_mail_frm").attr("action"),
			  data:formData,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        dataType:"JSON",
			  success: function(data)
			  {
				  //alert(data.post);
				  //alert(data.email_debugger);
          // $("input").val("");
          
				  $(".fsa_info").html(data.notification);
				  $("#reset-btn").click();
          reseto();
			  },
			  error:function(err){
					alert(err.toSource());	  
				  
			  }
		  });
			  
	  }
	  
	  function preview_email()
	  {
		  
		   var ec = CKEDITOR.instances.email_content.getData(); // CKEDITOR.instances.editor1.getData();
		   $("#message").val(ec);
       var formData = new FormData($("#send_mail_frm")[0]);
		  // alert($("#send_mail_frm").serialize());
		  $.ajax({
			type:"POST",
			url:"<?=base_url("agentsea/preview_email_agentsea")?>",
			data:formData,

    async: false,
    cache: false,
    contentType: false,
    processData: false,
			dataType:"JSON",
			success: function(res)
			{
				// alert(res);
				//$("#reset-btn").hide();
				//$("#back-btn").show();
				re_reseto();
				if(res.status == "success")
				{
					$(".preview-emailnya").html(res.result).show("fast");
          res.list_email = JSON.stringify(res.list_email);
          $("#list_email").val(res.list_email);
				}
				else
				{
					$(".fsa_info").html(res.result);
				}
				
			}
			  
		  })
			  
	  }
	  
	  $(document).ready(function(e) {
		 
		 reseto();
		 
		  $('#send_email_form').modal({
			show:true,
			backdrop:"static"
		  }); 
		  
		  $("#save-change").click(function(){
			  
			  var ec = CKEDITOR.instances.email_content.getData(); // CKEDITOR.instances.editor1.getData();
		 	  $("#message").val(ec);
			  
			  submit_send_email();
			  
		  });
		  
	  });

   </script>
    
    <!-- DataTables JavaScript -->
    <?php /* 
    <script src="<?php echo bower_url(); ?>/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo bower_url(); ?>/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>

        var source = "<?php echo isset($dt_list_source) ? $dt_list_source : ""; ?>";
        var baseURL = "<?php echo $base_url; ?>";
        var tableName = "<?php echo $table_name; ?>"; // for bulk action
        var controllerName = "<?php echo $controller_name; ?>"; // for link to page detail
        var oTable = null;

        var csrfTokenName = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

        var settings = {
            processing: true,
            autoWidth: false,
            ajax: {
                url: source,
                type: "POST",
                data: function(data) {
                    data.token_field = csrfHash;
                }
            },
            serverSide: true,
            lengthChange: false,
            searching: true,
            pageLength: 10,
            dom: '<"H"r>t<"F"ip>',
            order: [
                [1, 'asc']
            ],
            columns: [
                { visible: true, searchable: false, orderable: false, className: "center reference", width: "2%", data: "checkbox"},

                { visible: true, searchable: true, orderable: true, className: "left name", width: "25%", data: "name", name: "name"},
                { visible: true, searchable: true, orderable: true, className: "left ", width: "70%", data: "type", name: "type"},
                { visible: true, searchable: false, orderable: false, className: "left", width: "3%", data: "delete_link"}
            ],
            responsive: true,
            drawCallback: function() {

                listCheckboxes = {};
                $("input[name=id_all]").prop("checked", false);
            }
        };
		
		var settingt = {
            // processing:   true,
            "paging"	: true,
			"ordering"  : false,
			"info"      : false,
			"searching" : true
           
        };


        $(document).ready(function () {

            oTable = $('#dataTables-list').DataTable(settings);
		
			
            $("input[name=filter_1]").on("keyup change", function () {
                oTable.column(1).search($(this).val()).draw();
            });

            $("input[name=filter_2]").on("keyup change", function () {
                oTable.column(2).search($(this).val()).draw();
            });
        });

    </script> */ ?>

<?php echo js("bulk_action.js"); ?>

<?php $this->load->view("element/footer"); ?>