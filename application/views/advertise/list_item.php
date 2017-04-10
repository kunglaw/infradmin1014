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
    
    <div id="page-wrapper">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header">
                    Advertise management               
                    
                    <span class="pull-right">
            			<!-- button -->
                        
                   
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
                                <li role="presentation" class="<?=$al_active?>">
                                  <a href="<?=base_url("advertise?tab=request_ad")?>"  >
                                      List Request Ad
                                  </a>
                                </li>
                                <li role="presentation" class="<?=$lpy_active?>">
                                  <a href="<?=base_url("advertise?tab=list_payment")?>"  >List Payment</a>
                                </li>
                                <li role="presentation" class="<?=$lp_active?>">
                                  <a href="<?=base_url("advertise?tab=list_price")?>"  >List Price</a>
                                </li>
                              
                              </ul>
                            
                              <!-- Tab panes -->
                              <div class="tab-content">
                              	<?php if($al_active == "active"){ ?>
                                
                                <br>
                                <span class="clearfix"></span>
                                <!-- <input type="button" value="Delete Request Ad" id="delete-request-ad" class="btn btn-primary pull-left" >-->
                                
                                <div class="form-group col-md-2 pull-right">
                                <input type="text" value="" id="" name="filter_1" class="form-control" placeholder="Ad name...." >
                                </div>
                                
                                <span class="clearfix"></span>
                                
                                <div role="tabpanel" class="tab-pane <?=$al_active?>" id="invite_new_company">
                                	<br>

									<?php $this->load->view("advertise/table_ad_order"); ?>
									
                                </div>
                                <?php } ?>

                                <?php if($lpy_active == "active"){ ?>
                                
                                <br>
                                <span class="clearfix"></span>
                                <!-- <input type="button" value="Delete Payment Confirmation" id="delete-request-ad" class="btn btn-primary pull-left" > -->
                                
                                <div class="form-group col-md-2 pull-right">
                                <input type="text" value="" id="" name="filter_1" class="form-control" placeholder="Ad name...." >
                                </div>
                                
                                <span class="clearfix"></span>
                                
                                <div role="tabpanel" class="tab-pane <?=$lpy_active?>" id="">
                                	<br>

									<?php $this->load->view("advertise/table_payment_confirmation"); ?>
									
                                </div>
                                <?php } ?>
                                
                                <?php if($lp_active == "active"){ ?>
                                 
                                 <br>
                                 <!-- <input type="button" value="Delete Email" id="delete-email" class="btn btn-primary " style="display: none">-->
                                 
                                  <div class="form-group col-md-2 pull-right">
                                <input type="text" value="" id="" name="filter_1" class="form-control" placeholder="name...." >
                                </div>
                                <span class="clearfix"></span>
                                <div role="tabpanel" class="tab-pane <?=$lp_active?>" id="send_email">
                                	<br>
                                
                                	<?php $this->load->view("advertise/table_ad_price"); ?>
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
                <!-- <iframe src="https://calendar.google.com/calendar/embed?src=urp2usivgeaolb32pjhkeg20hg%40group.calendar.google.com&ctz=Asia/Jakarta" style="border: 0" width="800" height="600" frameborder="0" scrolling="no"></iframe> -->
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

		function show_edit_modal(id, jenis) {
		  var data = "x=1&id="+id;
		  $.ajax({
			data: data,
			type: "POST",
			url : "<?php echo base_url() ?>advertise/show_modal",
			success: function (output){
			  $(".se-modal-temp").html(output);
			}
		  })
		}
		
		$("#delete-request").on('click', function () {
			var ids = [];
			$(".toedit").each(function () {
				if ($(this).is(":checked")) {
					ids.push($(this).val());
				}
			});
			if (ids.length) {
				$.ajax({
					type: 'POST',
					url: "<?=base_url("advertise/delete_few_request");?>",
					data: {
						id: ids,
						html: ids.join()
					},
					beforeSend: function(data)
					{
						var c = confirm("Are You sure want to delete these request ? ");
						
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
		
		function activate_modal(id_ad)
		{
			$.ajax({
				type:"POST",
				data:"id_ad="+id_ad,
				url:"<?=base_url("advertise/modal_activate")?>",
				success: function(dt)
				{
					$(".se-modal-temp").html("");
					$(".se-modal-temp").html(dt);
				}
			});
			
		}
		
		function paid_status_modal(id_ad)
		{
			$.ajax({
				type:"POST",
				data:"id_ad="+id_ad,
				url:"<?=base_url("advertise/paid_status_modal")?>",
				success: function(dt)
				{
					$(".se-modal-temp").html("");
					$(".se-modal-temp").html(dt);
				}
			});
			
		}
		
		function delete_email(id)
		{
			$.ajax({
				type:"POST",
				data:"id="+id,
				url:"<?=base_url("advertise/delete_modal")?>",
				success: function(dt)
				{
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
        var csrfHash      = '<?php echo $this->security->get_csrf_hash(); ?>';

        var settings = {
			
            processing: true,
            autoWidth: false,
          
            lengthChange: false,
            searching: true,
			ordering:false,
            pageLength: 10,
            dom: '<"H"r>t<"F"ip>',
          
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