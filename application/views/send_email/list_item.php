<?php
/**
 * Created by PhpStorm.
 * User: pulung
 * Date: 29/10/14
 * Time: 13:00
 */
?>
<?php $this->load->view("element/header");
    
 ?>
<div class="se-modal-temp"></div>

    <!-- DataTables CSS -->
    <link href="<?php echo bower_url("datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css"); ?>" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="<?php echo bower_url("datatables-responsive/css/dataTables.responsive.css"); ?>" rel="stylesheet">

<div id="modal-block-seatizen"></div>
    
    <div id="page-wrapper">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header">
                    EMAIL MANAGEMENT                    
                    
                    <span class="pull-right">
                    	
                        <span class="pull-right">
                          <a class="button-green-white" style="margin-right:10px;" onclick="" href="<?=base_url("agentsea/send_email_page")?>">
                              <i class="glyphicon glyphicon-plus-sign"></i> 
                              Invite new company 
                          </a>
                        </span>
                        
                        <a href="<?=base_url("send_email/form_send_email")?>" target="_blank" class="button-green-white" 
                        style="margin-right:10px;" onclick="">
                        	<i class="glyphicon glyphicon-plus-sign"></i> 
                            Compose 
                        </a>
                        
                   
                    </span>
                </h1>
            </div>
            <!-- /.col-md-12 -->
        </div>
        <!-- /.row -->


        <?php show_notification(); ?>


        <div class="row">

            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-body">

                        <div class="row">
                            <div class="col-md-12">


                            </div>
                            <!-- /.col-md-12 -->
                        </div>
                        <!-- /.row -->

                        <div class="row">
                            <div class="col-md-12">
                                
                              <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="<?=$inc_active?>">
                                  <a href="<?=base_url("send_email?tab=invite_new_company")?>"  >
                                      Invite New Company
                                  </a>
                                </li>
                                
                                <li role="presentation" class="<?=$se_active?>">
                                  <a href="<?=base_url("send_email?tab=send_email")?>"  >Send Email</a>
                                </li>
                              
                              </ul>
                            
                              <!-- Tab panes -->
                              <div class="tab-content">
                              	<?php if($inc_active == "active"){ ?>
                                
                                <br>
                                <span class="clearfix"></span>
                                <input type="button" value="Delete Email Agentsea" id="delete-email-agentsea" class="btn btn-primary pull-left" >
                                
                                <div class="form-group col-md-2 pull-right">
                                <input type="text" value="" id="" name="filter_1" class="form-control" placeholder="company name...." >
                                </div>
                                
                                <span class="clearfix"></span>
                                
                                <div role="tabpanel" class="tab-pane <?=$inc_active?>" id="invite_new_company">
                                	<br>

									<div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-list">
                                        <thead class="button-green-white">
                                        <tr>
                                            <th style="text-align: center;"> No </th>
                                            <th>Company Name</th>
                                            <th>Contact Person</th>
                                            <th>to</th>
                                            <th>Note</th>
                                            <!-- <th>Attachment</th> -->
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        	
                                            foreach ($list_email as $dt) {
                                                
                                                $data_content = "<div> PIC : ".$dt['PIC']." </div>".
                                                "<div> on: ".$dt['datetime']." </div> ";
                                                $title_popup = "Note:";
										?>
                                            <tr <?=$class ?>>
                                              <td class="center reference" >
                                                  	
                                                    <input type="checkbox" value="<?=$dt['id']?>" name="check[]" class="toedit" >
                                                    
                                                    <span data-toggle="popover" data-content="<?=$data_content?>" 
                                                    title="<?=$title_popup?>" class="ipop">
                                                    	<?=$dt['id']?>
                                                    </span>
                                              </td>
                                              <td class="left name" >
                                                <div data-toggle="popover" class="ipop pull-left" data-content="<?=$data_content?>" 
                                                title="<?=$title_popup?>"> 
                                                    <?=$dt['company_name']?>                                          
                                                </div>
                                              </td>
                                              <td class="left linkable" >
                                                <div data-toggle="popover" class="ipop" data-content="<?=$data_content?>"
                                                title="<?=$title_popup?>"> 
                                                	<?=$dt['contact_person']?>
                                                </div>
                                              </td>
                                              <td class="left linkable" >
                                                <div data-toggle="popover" class="ipop" data-content="<?=$data_content?>"
                                                title="<?=$title_popup?>"> 
                                                	<?=$dt['email']?> 
                                                </div>
                                              </td>
                                              <td>
												<?=$row['note']?>
                                              </td>
                                             
                                              <td align="center">
                                              	  
                                                  
                                                  <a href="<?=base_url("send_email/detail_email_agentsea/$dt[id]")?>" target="_blank" class="btn btn-primary" title="" 
                                                 >

                                                  	<span class="glyphicon glyphicon-eye-open"></span>
                                                  </a>
                                                  
                                                  <a class="btn btn-primary" title="Delete" onClick="delete_email_agentsea(<?=$dt['id']?>)" 
                                                  href="#">

                                                  	<span class="glyphicon glyphicon-trash"></span>
                                                  </a>
                                                  
                                                  
                                              </td>
                                          </tr>
                                                <?php
												
                                            }
											
                                         ?>
                                        </tbody>
                                    </table>
                                </div>
									
                                </div>
                                <?php } ?>
                                
                                <?php if($se_active == "active"){ ?>
                                 
                                 <br>
                                 <input type="button" value="Delete Email" id="delete-email" class="btn btn-primary " >
                                 
                                  <div class="form-group col-md-2 pull-right">
                                <input type="text" value="" id="" name="filter_1" class="form-control" placeholder="name...." >
                                </div>
                                
                                <div role="tabpanel" class="tab-pane <?=$se_active?>" id="send_email">
                                <br>
                                
                                	<div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-list">
                                        <thead class="button-green-white">
                                        <tr>
                                            <th style="text-align: center;"> No </th>
                                            <th>Name</th>
                                            <th>To</th>
                                            <th>Subject</th>
                                            <th>Type Email</th>
                                            <!-- <th>Attachment</th> -->
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        	
                                            foreach ($list_email as $dt) {
                                                
                                                $data_content = "<div> PIC : ".$dt['pic']." </div>".
                                                "<div> on: ".$dt['datetime']." </div> ";
                                                $title_popup = "Note:";
										?>
                                            <tr <?=$class ?>>
                                              <td class="center reference" >
                                                  	
                                                    <input type="checkbox" id="delete-email" value="<?=$dt['id']?>" name="se[]" class="del-sm">
                                                    
                                                    <span data-toggle="popover" data-content="<?=$data_content?>" 
                                                    title="<?=$title_popup?>" class="ipop">
                                                    	<?=$dt['id']?>
                                                    </span>
                                              </td>
                                              <td class="left name" >
                                                <div data-toggle="popover" class="ipop pull-left" data-content="<?=$data_content?>" 
                                                title="<?=$title_popup?>"> 
                                                    <?=$dt['name']?>                                          
                                                </div>
                                              </td>
                                              <td class="left linkable" >
                                                <div data-toggle="popover" class="ipop" data-content="<?=$data_content?>"
                                                title="<?=$title_popup?>"> 
                                                	<?=$dt['email_to']?>
                                                </div>
                                              </td>
                                              <td class="left linkable" >
                                                <div data-toggle="popover" class="ipop" data-content="<?=$data_content?>"
                                                title="<?=$title_popup?>"> 
                                                	<?=$dt['subject']?> 
                                                </div>
                                              </td>
                                              <td class="left linkable" >
                                                <div data-toggle="popover" class="ipop" data-content="<?=$data_content?>"
                                                title="<?=$title_popup?>"> 
                                                	<?=$dt['type_email']?>
                                                </div>
                                              </td>
                                              <!-- <td class="left linkable">
                                                <div data-toggle="popover" class="ipop" data-content="<?=$data_content;?>"
                                                    title="<?=$title_popup;?>">
                                                    <?=$dt['attachment']?> 
                                                </div>
                                              </td> -->
                                              <td align="center">
                                              	  <a target="_blank" class="btn btn-primary" title="Send Another" 
                                                  href="<?=base_url("send_email/form_edit_email?name=$dt[name]&email=$dt[email_to]")?>">
                                                  
                                                  	<span class="glyphicon glyphicon-send"></span>
                                                  	
                                                 
                                                  </a>
                                                  
                                                  <a href="<?=base_url("send_email/preview_email/$dt[id]")?>" target="_blank" class="btn btn-primary" title="" 
                                                 >

                                                  	<span class="glyphicon glyphicon-eye-open"></span>
                                                  </a>
                                                  
                                                  <a class="btn btn-primary" title="Delete" onClick="delete_email(<?=$dt['id']?>)" 
                                                  href="#">

                                                  	<span class="glyphicon glyphicon-trash"></span>
                                                  </a>
                                                  
                                                  
                                              </td>
                                          </tr>
                                                <?php
												
                                            }
											
                                         ?>
                                        </tbody>
                                    </table>
                                </div>
                                </div>
                                <?php } ?>
                                
                              </div>
                                
                                
                                
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.col-md-12 -->
                        </div>
                        <!-- /.row -->


                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-md-12 -->
        </div>
        <!-- /.row -->

    </div>
    <!-- /#page-wrapper -->

    <!-- DataTables JavaScript -->
    <script src="<?php echo bower_url(); ?>datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo bower_url(); ?>datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>


    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		
		$("#delete-email").on('click', function () {
			var ids = [];
			$(".del-sm").each(function () {
				if ($(this).is(":checked")) {
					ids.push($(this).val());
				}
			});
			if (ids.length) {
				$.ajax({
					type: 'POST',
					url: "<?=base_url("send_email/delete_few_email");?>",
					data: {
						id: ids,
						html: ids.join()
					},
					beforeSend: function(data)
					{
						var c = confirm("Are You sure want to delete these email ? ");
						
						if(!c)
						{
							return false;	
						}
						
					},
					success: function (data) {
						
						alert(data);
						location.reload();
						//$("p").text(data);
					}
				});
			} else {
				alert("Please select items.");
			}
		});
		
		$("#delete-email-agentsea").on('click', function () {
			var ids = [];
			$(".toedit").each(function () {
				if ($(this).is(":checked")) {
					ids.push($(this).val());
				}
			});
			if (ids.length) {
				$.ajax({
					type: 'POST',
					url: "<?=base_url("send_email/delete_few_email_agentsea");?>",
					data: {
						id: ids,
						html: ids.join()
					},
					beforeSend: function(data)
					{
						var c = confirm("Are You sure want to delete these email ? ");
						
						if(!c)
						{
							return false;	
						}
						
					},
					success: function (data) {
						
						alert(data);
						location.reload();
						//$("p").text(data);
					}
				});
			} else {
				alert("Please select items.");
			}
		});
		
		function form_compose()
		{
			
			$.ajax({
				
				type:"POST",
				url:"<?=base_url("send_email/form_send_email")?>",
				data:"x=1",
				success:function(data){
					
					$(".seatizen-modal-temp").html(data);
				}
				
			});
				
			
		}
		
		function delete_email(id)
		{
			$.ajax({
				type:"POST",
				data:"id="+id,
				url:"<?=base_url("send_email/delete_modal")?>",
				success: function(dt)
				{
					$(".se-modal-temp").html("");
					$(".se-modal-temp").html(dt);
				}
				
			});
		}
		
		function delete_email_agentsea(id)
		{
			$.ajax({
				type:"POST",
				data:"id="+id,
				url:"<?=base_url("send_email/delete_modal_agentsea")?>",
				success: function(dt)
				{
					//alert(dt);
					$(".se-modal-temp").html("");
					$(".se-modal-temp").html(dt);	
				}
				
				
			});
			
		}

        function cek_all () {
                // body...
                var state = $("#cek_all").prop("checked");
                $("#dataTables-list").parent().find(".reference").find("input[name=list_checkboxes\\[\\]]").prop("checked", state);
        }
		
        var source 		 = "<?php echo isset($dt_list_source) ? $dt_list_source : ""; ?>";
        var baseURL 	    = "<?php echo $base_url; ?>";
        var tableName 	  = "<?php echo $table_name; ?>"; // for bulk action
        var controllerName = "<?php echo $controller_name; ?>"; // for link to page detail
        var oTable 		 = null;

        var csrfTokenName = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

        var settings = {
            processing: true,
            autoWidth: false,
            // ajax: {
            //     url: source,
            //     type: "POST",
            //     data: function(data) {
            //         data.token_field = csrfHash;
            //     }
            // },
            // serverSide: true,
            lengthChange: false,
            // columnDefs:[{orderable: false, targets: [0]}],
            searching: true,
			ordering:false,
            pageLength: 10,
            dom: '<"H"r>t<"F"ip>',
            // order: [
            //     [1, 'asc']
            // ]
            // columns: [
            //     { visible: true, searchable: false, orderable: false, className: "center reference", width: "3%", data: "checkbox"},

            //     { visible: true, searchable: true, orderable: true, className: "left linkable name", width: "23%", data: "name", name: "name"},
            //     { visible: true, searchable: true, orderable: true, className: "left linkable", width: "20%", data: "email", name: "email"},
            //     { visible: true, searchable: true, orderable: true, className: "left linkable", width: "20%", data: "department", name: "department"},
            //     { visible: true, searchable: true, orderable: true, className: "left linkable", width: "20%", data: "gender", name: "gender"},
            //     { visible: true, searchable: true, orderable: true, className: "left linkable", width: "8%", data: "status", name: "status"},

            //     { visible: true, searchable: false, orderable: false, className: "left", width: "3%", data: "log_link"},
            //     { visible: true, searchable: false, orderable: false, className: "left", width: "3%", data: "block_link"}
            // ],
            responsive: true,
          
        };

        

        $(document).ready(function () {
            // alert("document eady");

            $(".role-popover").popover({
                trigger   :'hover',
                'placement'  :'top',
                animation   :true,
                //container :false,
                title       :'info',
                
                delay       :1, // { "show": 500, "hide": 100 }
                html         :true,
                //placement:'right',
                //'selector':'false',
                template:'<div class="popover col-md-4" style="border:1px solid #CCC" ><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
                
                //viewport:{ selector: 'body', padding: 0 }
                
            });
            
            $(".ipop").popover({
                trigger   :'hover',
                'placement'  :'top',
                animation   :true,
                //container :false,
                title       :'Info',
                delay       :1, // { "show": 500, "hide": 100 }
                html         :true,
                //placement:'right',
                //'selector':'false',
                template:'<div class="popover col-md-4" style="border:1px solid #CCC" ><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
                
                //viewport:{ selector: 'body', padding: 0 }
            });

            oTable = $('#dataTables-list').DataTable(settings);

            // alert("saya berubah");

            $("input[name=filter_1]").on("keyup change", function () {
                // alert("saya berubah");
                oTable.column(1).search($(this).val()).draw();
            });

            $("input[name=filter_2]").on("keyup change", function () {
                oTable.column(2).search($(this).val()).draw();
            });


            $("#dataTables-list").on("click", "td.linkable", function () {
                //var reference = $(this).parent().find(".reference").find("input[name=list_checkboxes\\[\\]]").val();
                //document.location.href = baseURL + controllerName + "/detail/page/" + reference;
            });
			
			// trigger file upload to show.
            $("#import-popup").click(function() {
                $("input[name=excel_file]").click();
            });

        });

    </script>

<?php echo js("bulk_action.js"); ?>

<?php $this->load->view("element/footer"); ?>