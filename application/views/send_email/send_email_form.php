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
                        <a href="<?php echo base_url("send_email"); ?>" style="color: #3093E4;">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                    </span>
                    	
                        Send Email 
					
                    <span class="clearfix"></span>
                </h1>
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

                               <form method="post" action="<?=base_url("send_email/send_process")?>" role="form" id="send_mail_frm" enctype="multipart/form-data">
                                <div class="fsa_info"></div>
                                
                                <style>
									/*style tambahan untuk preview email */
									
								
								
								</style>
                                <span class="clearfix"></span>
                                <div class="preview-emailnya">
                                </div>
                                <!-- <iframe src="">
                                
                                </iframe> -->
                                <span class="clearfix"></span>
                                <div class="btn-panel-email" class="" hidden="true">
                                	<a class="btn btn-default" id="back-to-form-email"> Back </a>
                                    <a class="btn btn-success" id="save-change">Send Email</a>
                                </div>

                                    <!-- ====================================================================================================================== -->

                                    <div id="form-emailnya">
                                        
                                    
                                    <div class="form-group">
                                          <label> From </label>
                                          <select name="email_from" id="email_from" onchange="validate_pass()" style="width:80%" class="form-control">
                                            <option selected>info@informasea.com</option>
                                            <option >rifalqori@informasea.com</option>
                                            <option >rini@informasea.com</option>
                                            <option >alhusna901@informasea.com</option>
                                            <option >dimas@informasea.com</option>
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
                                      <div class="form-group col-md-2" style="margin-left: -15px">
                                          <label> to </label>
                                          <input type="email" name="email" class="form-control" placeholder="email to" id="email">
                                      </div>
                                      
                                      <div class="form-group col-md-2">
                                          <label for=""> Name </label>
                                          <span class="clearfix">
                                          <input type="text" class="form-control pull-left" onchange="$('#nama_picnya').html(this.value)"  name="name" id="name" placeholder="name">
                                         
                                          </span>
                                      </div>
                                      
                                    
                                    <span class="clearfix"></span>
                                    <div class="form-group">
                                        <label for=""> Subject </label>
                                        <span class="clearfix">
                                        <input type="text" class="form-control pull-left" style="width:80%" name="subject" id="subject" 
                                        placeholder="subject">
                          
                                        </span>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label> Type Email </label>
                                        <span class="clearfix"></span>
                                        <div class="col-md-1">
                                          <div class="radio">
                                            <label>
                                              <input type="radio" id="" class="type_emailnya" name="type" value="seatizen_list" > 
                                               Seatizen List
                                            </label>
                                          </div>
                                        </div>

                                        <div class="col-md-1">
                                          <div class="radio">
                                            <label>
                                              <input type="radio" id="" class="type_emailnya" name="type" value="contract_offer" > 
                                               Offer a Contract
                                            </label>
                                          </div>
                                        </div>
                                        
                                        <div class="col-md-1">
                                          <div class="radio">
                                            <label>
                                              <input type="radio" class="type_emailnya" name="type" value="vacantsea_list" > 
                                              Vacantsea List
                                            </label>
                                          </div>
                                        </div>
                                        
                                        <div class="col-md-1">
                                          <div class="radio">
                                            <label>
                                              <input type="radio" class="type_emailnya" name="type" value="view_resume" > 
                                              View Resume
                                            </label>
                                          </div>
                                        </div>
                                        
                                        <div class="col-md-1">
                                          <div class="radio">
                                            <label>
                                              <input type="radio" class="type_emailnya" name="type" value="agentsea_list" > 
                                              Agentsea List
                                            </label>
                                          </div>
                                        </div>
                                        
                                        <div class="col-md-1">
                                          <div class="radio">
                                            <label>
                                              <input type="radio" class="type_emailnya" name="type" value="view_dashboard" > 
                                              View Dashboard
                                            </label>
                                          </div>
                                        </div>
                                        
                                        <div class="col-md-1">
                                          <div class="radio">
                                            <label>
                                              <input type="radio" class="type_emailnya" name="type" value="demo" > 
                                              Demo Dashboard
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
                                    <input type="hidden" name="file_browse" id="file_browse">
                                    <span class="clearfix"></span> 
                                    <!-- Rank -->
                                    <div id="select_rank">
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
													<option value="<?php echo $row['rank_id']; ?>"><?php echo $row['rank']; ?></option>
												<?php
													}
												?>
                                            </select>
                                        </div>
                                        
                                        <div>
                                        	<label style="width: 20%"> Vessel Type </label>
                                          
                                        	<select name="vessel_type" id="vessel_type" class="form-control" style="width: 50%; display:inline;">
                                            	<?php
                 			
													foreach($vessel as $row)
													{
														
												?>
													<option value="<?php echo $row['type_id']; ?>">
														<?php echo $row['ship_type']; ?></option>
												<?php
													}
												?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div id="contract_information">
                                    <div class="form-group" id="comp_name">
                                        <label style="width: 20%"> Company Name </label>
                                        <!-- <span class="clearfix"> -->&nbsp;&nbsp;&nbsp;
                                        <input type="text" style="width: 50%; display:inline;" class="form-control" name="comp_name" id="comp_name" placeholder="please fill the Company Name">
                                       
                                        <!-- </span> -->
                                    </div>
                                    <span class="clearfix"></span>
                                    <div class="form-group" id="comp_address">
                                        <label style="width: 20%; vertical-align:top"> Company Address </label>
                                        <!-- <span class="clearfix"> -->&nbsp;&nbsp;&nbsp;
                                        <textarea type="text" style="width: 50%; display:inline;" class="form-control" name="comp_address" id="comp_address" placeholder="please fill the Company Address"></textarea>
                                       
                                        <!-- </span> -->
                                    </div>
                                    <span class="clearfix"></span>
                                    <div class="form-group" id="comp_telp">
                                        <label style="width: 20%"> Company Telp </label>
                                        <!-- <span class="clearfix"> -->&nbsp;&nbsp;&nbsp;
                                        <input type="number" style="width: 50%; display:inline;" class="form-control" name="comp_telp" id="comp_telp" placeholder="please fill the Company Telp Number">
                                       
                                        <!-- </span> -->
                                    </div>
                                    <span class="clearfix"></span>
                                    <div class="form-group" id="title_pic">
                                        <label style="width: 20%"> Title of <span id="nama_picnya"></span></label>
                                        <!-- <span class="clearfix"> -->&nbsp;&nbsp;&nbsp;
                                        <input type="text" style="width: 50%; display:inline;" class="form-control" name="title_pic" id="title_pic" placeholder="Manager/Director/Staff">
                                       
                                        <!-- </span> -->
                                    </div>
                                    <span class="clearfix"></span>
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
                                    
                                    <span class="pull-left"> &nbsp; &nbsp; </span>
                                    
                                    <div class="form-group pull-left">
                                        <label for=""> Attachment </label>
                                        <span class="clearfix">
                                        <input type="file" class="pull-left" name="attachment" id="attachment" placeholder="">
                          
                                        </span>
                                    </div> 
                                    
                                    <input type="hidden" name="message" id="message" value="">
                                   
                                   <span class="pull-left"> &nbsp; &nbsp; </span>
                                   
                                  <span class="clearfix"></span>
                                  
                                  <button type="reset" id="reset-btn" class="btn btn-default" onClick="resett()">Reset</button>
                                  <a class="btn btn-primary" id="show-preview-mail"> Preview Email </a>
                                  <!-- <button type="button" class="btn btn-success" id="save-change">Send Email</button> -->
                               	  
                                  
                                  
                                    </div> <!-- End of form-emailnya -->
        						 
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
	<script src="<?php echo infr_asset() ?>plugin/ckeditor/ckeditor.js"></script>
	<!-- <script src="<?php //echo plugin_url() ."tags_input/"; ?>bootstrap-tagsinput.min.js"></script> -->
	 <script>
        /* Replace the <textarea id="editor1"> with a CKEditor
        instance, using default configuration. */
        CKEDITOR.replace( 'email_content' );
    </script>
	<script>
	
	
	
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
	
	
	$("#contract_information").hide();
	$("#select_rank").hide();
	
	var department_id = $("#department").val(); 
		
        get_rank(department_id); 
	
	$(".type_emailnya").change(function () {
		// body...
		var typenya = $(this).val();
		
		//alert(typenya);
		
		if(typenya == "contract_offer") 
		{
			$("#contract_information").show('fast'); 
			$("#select_rank").hide('fast');
		}
		else if(typenya == "seatizen_list") 
		{
			$("#select_rank").show('fast'); 
			$("#contract_information").hide('fast');
		}
		else 
		{
			
			$("#contract_information").hide('fast'); 
			$("#select_rank").hide('fast');
		}
		
	})

		$('#pass_email').hide();
        var email_from, pass;
	  function validate_pass() {
          // body...
          email_from = $("#email_from").val();
          if(email_from != "info@informasea.com")
          {
            $("#pass_email").show('fast')/*.attr('placeholder', 'please insert email password from '+email)*/;
            $('#form-email-valid').find('input, textarea, button').attr('disabled', true);
          }
          else {
            $("#pass_email").hide('fast')/*.attr('placeholder', '')*/;
            // $('#form-email-valid').find('input, textarea, button').attr('disabled', false);
        }
      }
$("#back-to-form-email").click(function () {
    // body...
	$(".btn-panel-email").hide("fast");
    $(".preview-emailnya").hide("fast");
    $("#form-emailnya").show("fast");
})

$("#show-preview-mail").click(function(){
	//var type_email = $("input[type=radio]:checked").val();
	//alert(type_email);
	
	 var ec = CKEDITOR.instances.email_content.getData(); // CKEDITOR.instances.editor1.getData();
           $("#message").val(ec);
	
	list_template();	
});

$("#browse_img").change(function() {
  $("#file_browse").val($(this).val());
})

function list_template()
{
	var type_email = $("input[type=radio]:checked").val();
	//alert(type_email);	
	var formData = new FormData($("#send_mail_frm")[0]);
	$.ajax({
		
		type:"POST",
		url:"<?=base_url("send_email/preview_type")?>",
		data:formData, //$("#send_mail_frm").serialize()
		dataType:"json",
    async: false,
    cache: false,
    contentType: false,
    processData: false,
		success: function(res)
		{
      // alert(res);
			$("#form-emailnya").hide("fast");
			$(".preview-emailnya").show("fast");
			$(".btn-panel-email").show("fast");
			
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

    $("#show-preview-mail").click(function() {
        // body...
        var ec = CKEDITOR.instances.email_content.getData(); // CKEDITOR.instances.editor1.getData();
           $("#message").val(ec);
           var message = ec;
           var email_to = $("#email").val();
           // email_from = $("#email_from").val();
           $("#isi-pesan-email").html(message);
           var info_mail = $(".mailtoinfo");
           info_mail.attr("href", "mailto:"+email_from);
           info_mail.html(email_from);

           $("#mailtouser").html(email_to);
           // $("#save-change").show("fast");
           // $("#show-preview-mail").hide("fast");
           $("#preview-emailnya").show("fast");
           $("#form-emailnya").hide("fast");
    })
	  function submit_send_email()
	  {
        var formData = new FormData($("#send_mail_frm")[0]);
		  $.ajax({
			  type:"POST",
			  url:$("#send_mail_frm").attr("action"),
			  data:formData,
              // data: formData,
              async: false,
              cache: false,
              contentType: false,
              processData: false,
			  dataType:"json",
			  success: function(data)
			  {
				  //alert(data.notification);
				  $(".fsa_info").html(data.notification);
                  $("#reset-btn").click();
                  $(".preview-emailnya").hide("fast");
                  $(".btn-panel-email").hide("fast");
                  $("#form-emailnya").show("fast");
				  
			  }
		  });
			  
	  }
	  
	  function preview_email()
	  {
		  
		   var ec = CKEDITOR.instances.email_content.getData(); // CKEDITOR.instances.editor1.getData();
		   $("#message").val(ec);
		  
		  $.ajax({
			type:"POST",
			url:"<?=base_url("send_email/preview_email")?>",
			data:$("#send_mail_frm").serialize(),
			dataType:"JSON",
			success: function(res)
			{
				if(res.status == "success")
				{
					$("#agentsea-modal").html(res.result);	
				}
				else
				{
					//alert(res.notification);
				}
				
			}
			  
		  })
			  
	  }
	  
	  function resett()
	  {
		  $(".fsa_info").alert('close');  
	  }
	  
	  $("#preview-emailnya").hide();
      // $("#save-change").toggle(false);
	  $(document).ready(function(e) {
		 
         
		 
		 
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