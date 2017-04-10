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

<div class="agentsea-modal-temp"></div>

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
                AGENTSEA MANAGEMENT
                
                <span class="pull-right">
                  <a class="button-green-white" style="margin-right:10px;" onclick="" href="<?=base_url("agentsea/send_email_page")?>">
                      <i class="glyphicon glyphicon-plus-sign"></i> 
                      Invite new company 
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
                                        <th style="text-align: center;"></th>
                                        <th>Company</th>
                                        <th>CP</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th> Last login </th>
                                        <!-- <th>Activation Code </th> -->
                                        <!-- <th>Account Type</th> -->
                                        <th>Role</th>
                                        <th>View</th>
                                        <th> Tampil </th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    
                                    
                                    foreach($list_agentsea as $row){
                                        
                                        $last_login = $this->agentsea_model->last_login($row['id_perusahaan']);

                                        if(count($last_login) != 0){ 
										
                                        	$waktu = explode(" ",$last_login['action_time']);

                                        	$t_login = $waktu[0];
                                        }
										
                                        $arr_id = array(array("field"=>"id_object","val"=>$row['id_perusahaan']),
                                        array("field"=>"form","val"=>"edit_agentsea"));
                                    
                                        $arr_id2 = array(array("field"=>"id_object","val"=>$row['id_perusahaan']),
                                        array("field"=>"form","val"=>"role"));
                                        
                                        $arr_id3 = array(array("field"=>"id_object","val"=>$row['id_perusahaan']),
                                        array("field"=>"form","val"=>"account_type"));

                                        $arr_id4 = array(array("field"=>"id_object","val"=>$row['id_perusahaan']),
                                        array("field"=>"form", "val"=>"edit_tampil"));
                                        
                                        $adact      = $this->admin_activity->get_last_action("agentsea",$arr_id);
                                        $adact_role = $this->admin_activity->get_last_action("agentsea",$arr_id2);
                                        $adact_at   = $this->admin_activity->get_last_action("agentsea",$arr_id3);

                                        $adact_tampil = $this->admin_activity->get_last_action("agentsea",$arr_id4);

                                        $not_activated = "not-activated";
                                        $status_arr = explode("|",$row['status']);
                                        
                                        if($row['activation_code'] == "ACTIVE" || $row['activation_code'] == "TESTING")
                                        { 
                                            $not_activated = ""; 
                                        }
                                        else if($row['status'] == "VERIFIED" && $row['activation_code'] != "ACTIVE")
                                        {
                                            $not_activated = "blue";	
                                        }
                                        else if($row['status'] == "" && $row['activation_code'] != "ACTIVE")
                                        {
                                            $not_activated = "not-activated";
                                        }
                                        else if(!in_array("VERIFIED",$status_arr) && $row['activation_code'] != "ACTIVE" )
                                        {
                                            $not_activated = "pink";
                                        }
										
										// label for account type
										if($row['account_type'] == "Free"){ $label_type = "label-primary"; }
										
										else if($row['account_type'] == "Premium"){ $label_type = "label-success";}
										else if($row['account_type'] == "Premium_advance"){ $label_type = "label-success";}
										else if($row['account_type'] == "Free_trial"){ $label_type = "label-danger"; } 
                                        
                                        $title_popup = implode(", ",$status_arr);
                                        
                                         $data_content = "<div> PIC : $adact[username] </div>".
                                        "<div> on: $adact[datetime] </div> ";
                                        //<br> ";
                                        $data_content_role = "<div> PIC:$adact_role[username] </div>". 
                                        " <div> on: $adact_role[datetime] </div> ";
                                        
                                        $data_content_at = "<div> PIC:$adact_at[username] on $adact_at[datetime] </div> 
                                        <div> Action : $adact_at[action] </div> <hr> ".
                                        "<small class='text-small'>*click here to change account type </small>";

                                          $data_content_tampil = "<div> PIC : $adact_tampil[username] on $adact_tampil[datetime] </div>
                                        <div> Action : $adact_tampil[action] </div><hr>";
                                    
                                    ?>
                                       <tr>
                                          <td class="center reference" >
                                                <input type="hidden" value="<?=$row['id_perusahaan']?>" name="list_checkboxes[]">
                                                <span data-toggle="popover" data-content="<?=$data_content?>" 
                                                title="<?=$title_popup?>" class="ipop"> 
                                                <?=$row['id_perusahaan']?> </span>
                                          </td>
                                          <td class="left name" >
                                            <div data-toggle="popover" class="ipop pull-left <?=$not_activated?>" data-content="<?=$data_content?>" 
                                            title="<?=$title_popup?>">
                                                <?=$row['nama_perusahaan']?>                                                 
                                            </div>
                                            <a href="#" onclick="edit_account_type(<?=$row['id_perusahaan']?>)" 
                                            title="click hre to change account type " >
                                            
               
                                            
                                            <span class="label <?=$label_type?> pull-right ipop <?=$not_activated?>" data-toggle="popover" 
                                            data-content="<?=$data_content_at?>" title="Change Account type" >
                                                <span class="glyphicon glyphicon-edit"></span>&nbsp;
                                                <?=$row['account_type']?>
                                            </span>
                                            </a>
                                            
                                           <i class="pull-right">  &nbsp; </i>
                                            
                                            <a href="#" onclick="edit_official(<?=$row['id_perusahaan']?>)" 
                                            title="click hre to change Official " >

                                            <span class="label <?=$label_type?> pull-right ipop <?=$not_activated?>" data-toggle="popover" 
                                            data-content="<?=$data_content_at?>" title="Change Account type" >
                                                <span class="glyphicon glyphicon-edit"></span>&nbsp;
                                                <?=$row['official']?>
                                            </span>
                                            </a>
                                            
                                          </td>
                                          <td class="left linkable" >
                                            <div data-toggle="popover" class="ipop <?=$not_activated?>" data-content="<?=$data_content?>"
                                            title="<?=$title_popup?>" >
                                            <?=$row['contact_person']?> </div>
                                          </td>
                                          <td class="left linkable" >
                                            <div data-toggle="popover" class="ipop <?=$not_activated?>" data-content="<?=$data_content?>"
                                            title="<?=$title_popup?>"> 
                                            <?=$row['no_telp']?> </div>
                                          </td>
                                          <td class="left linkable" >
                                            <div data-toggle="popover" class="ipop <?=$not_activated?>" data-content="<?=$data_content?>"
                                            title="<?=$title_popup?>"> 
                                            <?=$row['email']?> </div>
                                          </td>
                                          
                                          <td class="left linkable">
                                            <div data-toggle="popover" class="ipop <?=$not_activated?>" data-content="<?=$data_content;?>"
                                                title="<?=$title_popup;?>">
                                                <?php 
                                            if(count($last_login) != 0){ 
                                                $xzzz = date('Y-m-d H:i:s');
                                                $now = new DateTime($xzzz);
                                                $terakhir = new DateTime($t_login);
                                            
                                             $difference = $terakhir->diff($now);

                                                if($difference->d < 1 AND $difference->days < 1){
                                                    echo "Today";
                                                }else if($difference->d > 1 AND $difference->days <= 7){
                                                    echo "This Week";
                                                }else if($difference->m < 1 AND $difference->days > 7){
                                                    echo "This Month";
                                                }else if($difference->m >1 AND $difference->y == 0){
                                                    echo "Last Month";
                                                }else if($difference->y == 1){
                                                    echo "1 years ago";
                                                }else if($difference->y > 1){
                                                    echo "More than 1 years ago";
                                                }

                                            }else{
                                                echo "-";
                                            }
                                                ?> 
                                            </div>

                                          </td>
                                          <td>
                                            <div class="role-popover " data-toggle="popover" data-content="<?=$data_content_role?>"
                                            title="<?=$title_popup?>">
                                              <?php if($row['activation_code'] == "ACTIVE" || $row['activation_code'] == "TESTING"){  ?>
                                                <?=$row['role']?>
                                              <?php }else{ ?>
                                              <a href="#" class="btn btn-default <?=$not_activated?>" onclick="edit_role(<?=$row['id_perusahaan']?>)">
                                                  <?=$row['role']?>
                                              </a>
                                              <?php } ?>
                                            </div>
                                          </td>
                                          <td>
                                          	<div data-toggle="popover" class="ipop <?=$not_activated?>" data-content="<?=$data_content?>"
                                            title="<?=$title_popup?>"> 
                                            	<?php echo $this->agentsea_model->jumlah_view($row['username']);?>
                                            </div>
                                          </td>
                                          <td>
                                            <div class="role-popover" data-toggle="popover" data-content="<?=$data_content_tampil?>" >

												<?php if($row['tampil'] == 1){ 
                                                    echo "Yes";
                                                }else{
                                                    echo "No";
                                                }
                                                ?>
                                            </div>

                                            <a href="#" class="label label-primary pull-right" onclick="edit_tampil(<?=$row['id_perusahaan'];?>)"> Edit </a>
                                          </td>
                                          <td>
                                          	
                                            <!-- Single button -->
                                            <div class="btn-group">
                                              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" 
                                              aria-haspopup="true" aria-expanded="false">
                                              	<i class="glyphicon glyphicon-menu-hamburger"></i>
                                                Setting <span class="caret"></span>
                                              </button>
                                              
                                              <ul class="dropdown-menu dropdown-menu-right">
                                              	<li>
                                                	<a href="#" onClick="edit_account_setting(<?=$row['id_perusahaan']?>)">
                                                    	<i class="glyphicon glyphicon-cog"></i> Account Setting 
                                                	</a>
                                                </li>
                                                <li>
                                                    <a href="<?=base_url("agentsea/log/$row[id_perusahaan]")?>" target="_blank">
                                                      <i class="fa fa-bars"></i> Agentsea Log
                                                    </a>
                                                </li>
                                                <li>
                                                	<a href='#' onclick='edit_agentsea(<?=$row['id_perusahaan']?>)' >
                                                        <i class="fa fa-edit"></i> Edit Agentsea
                                                    </a>
                                                </li>
                                                <li>
                                                	<a href="#" onClick="edit_role(<?=$row['id_perusahaan']?>)">
                                                    	<i class="glyphicon glyphicon-user"></i> Edit Role
                                                    </a>
                                                </li>
                                                <li>
                                                	<a href="#" onClick="edit_official(<?=$row['id_perusahaan']?>)">
                                                    	<i class="glyphicon glyphicon-briefcase"></i> Edit Official
                                                	</a>
                                                </li>
                                               
                                               
                                              </ul>
                                            </div>
                                            
                                              
                                              <!-- <a href="#" onclick="edit_agentsea_aktif(<?=$row['id_perusahaan'];?>)">
                                                <i class="fa fa-edit"> </i>
                                              </a> -->
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
			order: [[ 0, 'desc' ]],
            
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