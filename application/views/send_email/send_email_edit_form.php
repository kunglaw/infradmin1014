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

                               <form method="post" action="<?=base_url("send_email/send_process")?>" role="form" id="send_mail_frm" >
        						 <div class="fsa_info"></div>
                                    
                                    <div class="row">
                                      
                                      <div class="form-group col-md-2">
                                          <label> to </label>
                                          <input value="<?=$this->input->get('email')?>" type="email" name="email" class="form-control" id="email">
                                      </div>
                                      
                                      <div class="form-group col-md-2">
                                          <label for=""> Name </label>
                                          <span class="clearfix">
                                          <input value="<?=$_GET['name']?>" type="text" class="form-control pull-left"  name="name" id="name" >
                                         
                                          </span>
                                      </div>
                                      
                                    </div>
                                    
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
                                              <input type="radio" name="type" value="seatizen_list" > 
                                               Seatizen List
                                            </label>
                                          </div>
                                        </div>
                                        
                                        <div class="col-md-1">
                                          <div class="radio">
                                            <label>
                                              <input type="radio" name="type" value="vacantsea_list" > 
                                              Vacantsea List
                                            </label>
                                          </div>
                                        </div>
                                        
                                        <div class="col-md-1">
                                          <div class="radio">
                                            <label>
                                              <input type="radio" name="type" value="view_resume" > 
                                              View Resume
                                            </label>
                                          </div>
                                        </div>
                                        
                                        <div class="col-md-1">
                                          <div class="radio">
                                            <label>
                                              <input type="radio" name="type" value="agentsea_list" > 
                                              Agentsea List
                                            </label>
                                          </div>
                                        </div>
                                        
                                        <div class="col-md-1">
                                          <div class="radio">
                                            <label>
                                              <input type="radio" name="type" value="view_dashboard" > 
                                              View Dashboard
                                            </label>
                                          </div>
                                        </div>
                                        
                                        <span class="clearfix">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label> Content </label>
                                        <?php /*tambahkan CKE Editor*/ ?>
                                        <textarea class="form-control" style="width:100%" rows="10" name="email_content" id="email_content"></textarea>
                                    </div>
                                    
                                    <!-- <div class="form-group">
                                        <label for=""> Attachment </label>
                                        <span class="clearfix">
                                        <input type="file" class="pull-left" name="attachment" id="attachment" placeholder="">
                          
                                        </span>
                                    </div> --> 
                                    
                                    <input type="hidden" name="message" id="message" value="">
                                
                                  <button type="reset" id="reset-btn" class="btn btn-default" onClick="resett()">Reset</button>
                                  <button class="btn btn-primary" onClick="preview_email()"> Preview Email </button>
                                  <button type="button" class="btn btn-success" id="save-change">Send Email</button>
                               
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
        <link href="<?php echo bower_url("datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css"); ?>" rel="stylesheet">

        <!-- DataTables Responsive CSS -->
        <link href="<?php echo bower_url("datatables-responsive/css/dataTables.responsive.css"); ?>" rel="stylesheet">

        

    </div>
    <!-- /#page-wrapper -->

    <?php
    //$modal_delete_data = array();
    //$modal_delete_data["table_name"] = $delete_table_name;
    //$this->load->view("modal/delete_confirmation", $modal_delete_data);
    ?>
	<script src="http://www.informasea.com/informasea_assets/plugin/ckeditor/ckeditor.js"></script>
	 <script>
        /* Replace the <textarea id="editor1"> with a CKEditor
        instance, using default configuration. */
        CKEDITOR.replace( 'email_content' );
    </script>
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
				  $("#reset-btn").click();
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
					alert(res.notification);
				}
				
			}
			  
		  })
			  
	  }
	  
	  function resett()
	  {
		  $(".fsa_info").alert('close');  
	  }
	  
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