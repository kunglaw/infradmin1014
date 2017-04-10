<?php
/**
 * Created by PhpStorm.
 * User: pulung
 * Date: 29/10/14
 * Time: 13:00
 */
?>
<?php $this->load->view("element/header"); ?>

<div class="req-upgrade-temp"></div>

    <!-- DataTables CSS -->
    <link href="<?php echo bower_url("datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css"); ?>" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="<?php echo bower_url("datatables-responsive/css/dataTables.responsive.css"); ?>" rel="stylesheet">
    
    <?php include "js_top.php" ?>
    
    <style>
	.not-activated{
		background-color:#FC0 !important;	
	}
	
	.pink 
	{
		background-color:#F9F !important;	
	}
	
	.blue
	{
		background-color:#09F !important;	
	}
	</style>
	
<div id="modal-agentsea"></div>
<div id="page-wrapper">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                REQUEST UPGRADE
                
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

                            <?php
                            echo form_input(
                                array(
                                    "class" => " search",
                                    "name" => "filter_1",
                                    "placeholder" => "Company"
                                )
                            );
                            ?>

                            <?php
                            echo form_input(
                                array(
                                    "class" => " search",
                                    "name" => "filter_2",
                                    "placeholder" => "CP"
                                )
                            );
                            ?>
                        </div>
                        <!-- /.col-md-12 -->
                    </div>
                    <!-- /.row -->

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-list">
                                    <thead class="button-green-white">
                                    <tr>
                                        <th style="text-align: center;">Id</th>
                                        <th>No. invoice</th>
                                        <th>Company Name</th>
                                        <th>No Telp</th>
                                        <th>Email </th>
                                        <th>From Bank</th>
                                        <th>Purpose Bank</th> 
                                        <th>Request</th>
                                        <th>Date Order</th>
                                        <th>Status</th>                                         
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    
                                    
                                    foreach($list_rum as $row){
                                       
                                    
                                    ?>
                                       <tr>
                                          <td class="center reference" >
                                              <?=$row['id_request']?>
                                          </td>
                                          <td class="left name" >
                                          	  <?=$row['no_invoice']?>
                                          </td>
                                          <td class="left linkable">
                                            <div data-toggle="popover" class="ipop <?=$not_activated?>" data-content="<?=$data_content;?>"
                                                title="<?=$title_popup;?>">
                                              <?=$row['company_name']?>
                                           
                                            </div>
                                          </td>
                                          <td class="left linkable" >
                                          	 <?=$row['no_telp']?>
                                          </td>
                                          <td>
                                            <div class="role-popover " data-toggle="popover" data-content="<?=$data_content_role?>"
                                            title="<?=$title_popup?>">
                                              <?=$row['email']?>
                                            </div>
                                          </td>
                                          <td class="left linkable" >
                                            <div data-toggle="popover" class="ipop <?=$not_activated?>" data-content="<?=$data_content?>"
                                            title="<?=$title_popup?>"> 
                                              <?=$row['from_bank']?>
                                           </div>
                                          </td>
                                          <td>
                                          	<div data-toggle="popover" class="ipop <?=$not_activated?>" data-content="<?=$data_content?>"
                                            title="<?=$title_popup?>"> 
                                              <?=$row['purpose_bank']?>
                                          </td>                                          
                                          <td>
                                          	  <?php
											  $aaa = substr($row['no_invoice'],0,2);
											  
											  if($aaa == "UG")
											  {
												$bbb = "Upgrade";  
											  }else
											  {
												
												$bbb = "Downgrade";  
											   
											  }
											  
											  ?>
                                              <?php // campuran ?>
                                           	  <?=$bbb?> to '<b><?=$row['account_pilihan']?></b>' for <?=$row['req_month']?> Months
                                              <?php if($row['req_max_crew'] > 0)
                                              {
                                              	echo "and Crew_Quota = $row[req_max_crew]";
                                              }?>
                                          </td>
                                          <td>
                                          	  <?=$row['create_date']?>
                                          </td>
                                          <td>
                                             
                                           	  <span class="pull-left"> <?=$row['status']?> </span> &nbsp;
                                              
                                              <?php if($row['status'] == "confirm"){ ?>
                                              
                                                <a class="pull-right label label-primary" title="change status" 
                                                onClick="javascript:modal_req('change_status','<?=$row['no_invoice']?>')"> Change Status </a>
                                              
                                              <?php } else {  ?>
                                              
                                              	<a class="pull-right label label-default" title="change status" > Change Status </a>
                                              
                                              <?php } ?>
                                              
                                               <?php if($row['status'] == "paid"){ ?>
                                              
                                                <a class="pull-right label label-primary" title="change status" 
                                                onClick="javascript:modal_req('change_account','<?=$row['no_invoice']?>')"> Change Account </a>
                                              
                                              <?php } else {  ?>
                                              
                                              	<a class="pull-right label label-default" title="change status" > Change Account </a>
                                              
                                              <?php } ?>
                                              
                                              
                                          </td>
                                      </tr>
                                    <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
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
	
	
    <script>
	
		function modal_req(modal,no_invoice)
		{
			
			$.ajax({
				type:"POST",
				url:"<?=base_url("request_upgrade/modal")?>",
				data:"modal="+modal+"&no_invoice="+no_invoice,
				error: function(err)
				{
					
					
				},
				success:function(res){
					
					$(".req-upgrade-temp").html(res);
					
				}
			});

		}
	
	
	</script>
    
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		
		function send_email_form()
		{
			$.ajax({
				
				url:"<?=base_url("agentsea/send_email_form")?>",
				type:"POST",
				data:"x=1",
				success: function(data)
				{
						
					$(".agentsea-modal-temp").html(data);
				}
				
				
			});	
			
		}
		
		function test()
		{
			//alert("asdasdas");	
		}
		
		
		
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
            /* ajax: {
                url: source,
                type: "POST",
                data: function(data) {
                    data.token_field = csrfHash;
                }
            },*/
            //serverSide: true,
            lengthChange: false,
            searching: true,
            pageLength: 20,
            dom: '<"H"r>t<"F"ip>',
            
            /* columns: [
                { visible: true, searchable: false, orderable: false, className: "center reference data-popover", width: "", data: "checkbox"},

                { visible: true, searchable: true, orderable: true, className: "left linkable name data-popover", width: "", data: "name", name: "name"},
                { visible: true, searchable: true, orderable: true, className: "left linkable ", width: "", data: "cp", name: "cp"},
                { visible: true, searchable: true, orderable: true, className: "left linkable ", width: "", data: "phone", name: "phone"},
                { visible: true, searchable: true, orderable: true, className: "left linkable ", width: "", data: "email", name: "email"},
				//{ visible: true, searchable: true, orderable: true, className: "left linkable", width: "", data: "ac", name: "activation code"},
                //{ visible: true, searchable: true, orderable: true, className: "left linkable popover", width: "", data: "Account Type", name: "account_type"},
				{ visible: true, searchable: true, orderable: true, className: "left", width: "", data: "Role", name: "Role"},
                { visible: true, searchable: false, orderable: false, className: "left", width: "3%", data: "log_link"},
			    { visible: true, searchable: false, orderable: false, className: "left", width: "3%", data: "edit_form"}
            ],*/
            responsive: true,
            drawCallback: function() {

                listCheckboxes = {};
                $("input[name=id_all]").prop("checked", false);
            }
        };


        $(document).ready(function () {
			
			//$("h1").mouseenter(function(){ alert("hello"); });
			// INGA2, HARUS CLASSSSSSS
			$(".role-popover").popover({
				trigger	  :'hover',
				'placement'  :'top',
				animation	:true,
				//container	:false,
				title		:'info',
				
				delay		:1, // { "show": 500, "hide": 100 }
				html		 :true,
				//placement:'right',
				//'selector':'false',
				template:'<div class="popover col-md-4" style="border:1px solid #CCC" ><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
				
				//viewport:{ selector: 'body', padding: 0 }
				
			});
			
			$(".ipop").popover({
				trigger	  :'hover',
				'placement'  :'top',
				animation	:true,
				//container	:false,
				title		:'Info',
				delay		:1, // { "show": 500, "hide": 100 }
				html		 :true,
				//placement:'right',
				//'selector':'false',
				template:'<div class="popover col-md-4" style="border:1px solid #CCC" ><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
				
				//viewport:{ selector: 'body', padding: 0 }
			});			
			
            oTable = $('#dataTables-list').DataTable(settings);

            $("input[name=filter_1]").on("keyup change", function () {
                
                oTable.column(1).search($(this).val()).draw();
            });

            $("input[name=filter_2]").on("keyup change", function () {
                oTable.column(2).search($(this).val()).draw();
            });
			
				
            $("#dataTables-list").on("click", "td.linkable", function () {
                var reference = $(this).parent().find(".reference").find("input[name=list_checkboxes\\[\\]]").val();
                document.location.href = baseURL + controllerName + "/detail/page/" + reference;
            });
        });

    </script>

<?php echo js("bulk_action.js"); ?>

<?php include "js_under.php" ?>

<?php $this->load->view("element/footer"); ?>