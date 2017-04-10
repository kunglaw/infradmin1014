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
                        <a href="<?php echo base_url(); ?>agentsea" style="color: #3093E4;">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                    </span>
                    AGENTSEA DETAIL

                    <span class="pull-right">
                        <a href="<?php echo base_url() ."agentsea/log/". $item_id; ?>" class="button-green-white ">
                            Agentsea Log
                        </a>
                    </span>
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

                                <table class="company-detail">
                                    <thead class="button-green-white">
                                      <tr>
                                          <td colspan="2">
                                              <?php echo "<h3 style='float:left; margin-right:20px'> $nama_perusahaan </h3>"; ?> 
                                              <a href="http://informasea.com/agentsea/<?php echo $username;?>/home"  target="_blank" class="button-green-white" style="background:white; color:black; line-height:63px"> 
                                              	View Hull 
                                              </a>
                                              <span style="clear:both"></span>
                                          </td>
                                      </tr>
                                    </thead>
                                    <tbody>

                                      <?php /* <tr>
                                          <td>Description</td>
                                          <td><?php echo $description; ?></td>
                                      </tr> */ ?>
  									  
                                      <tr>
                                          <td>Username</td>
                                          <td><?php echo $username; ?></td>
                                      </tr>
                                      
                                      <tr>
                                          <td>Nationality</td>
                                          <td><?php echo flag_nationality($nationality); ?></td>
                                      </tr>
  
                                      <tr>
                                          <td>Website</td>
                                          <td><?php echo $website; ?></td>
                                      </tr>
  
                                      <tr>
                                          <td>Telephone</td>
                                          <td><?php echo $no_telp; ?></td>
                                      </tr>
  
                                      <tr>
                                          <td>Fax</td>
                                          <td><?php echo $fax; ?></td>
                                      </tr>
  
                                      <tr>
                                          <td>Email</td>
                                          <td><?php echo $email; ?></td>
                                      </tr>
  
                                      <tr>
                                          <td>Address</td>
                                          <td><?php echo $address; ?></td>
                                      </tr>
  
                                      <tr>
                                          <td>Location</td>
                                          <td><?php echo $location; ?></td>
                                      </tr>
                                      <tr>
                                          <td> Contact Person / Role </td>
                                          <td>  <?php echo $contact_person." / ".$role; ?> </td>
                                      </tr>
                                      <tr>
                                      	  <td>Register From </td>

                                        <?php $this->load->helper("date"); ?>
                                          <td><?php echo $register_from; ?> at <?php echo date_format_db($create_date); ?></td>
                                      </tr>
                                   

                                    </tbody>
                                </table>

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

        <div class="row">
            <div class="col-md-12">
                <h3>
                    VESSEL LIST
                </h3>
            </div>
            <!-- /.col-md-12 -->
        </div>
        <!-- /.row -->

        <?php show_notification(); ?>

        <div class="row" style="">

            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-body">

                        <div class="row">
                            <div class="col-md-12">

                                <?php
                                echo form_button(
                                    array(
                                        "class" => "button-green-white ",
                                        "data-toggle" => "modal",
                                        "data-target" => "#delete-many-confirmation"
                                    ),
                                    "Delete"
                                );
                                ?>

                                <?php
                                echo form_input(
                                    array(
                                        "class" => " search",
                                        "name" => "filter_1",
                                        "placeholder" => "Name"
                                    )
                                );
                                ?>

                                <?php
                                echo form_input(
                                    array(
                                        "class" => " search",
                                        "name" => "filter_2",
                                        "placeholder" => "Type"
                                    )
                                );
                                ?>
                            </div>
                            <!-- /.col-md-12 -->
                        </div>
                        <!-- /.row -->

                        <div class="row" style="">
                            <div class="col-md-12">

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-list">
                                        <thead>
                                        <tr>
                                            <th style="text-align: center;"><input type="checkbox" name="id_all"></th>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->

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
        
		
        <!-- ======================================================= History PIC ==================================== -->
        
        <!-- pic -->
         <div class="row">
            <div class="col-md-12">
                <h3>
                    History PIC 
                </h3>
            </div>
         </div>
         
         <div class="row">

            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-body">

                        <div class="row">
                            
                            <!-- /.col-md-12 -->
                        </div>
                        <!-- /.row -->

                        <div class="row" style="margin-bottom: 80px;">
                            <div class="col-md-12">

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-list">
                                        <thead style="color:black;">
                                        <tr>
                                            <th>No</th>
                                            <th>PIC</th>
                                            <th>Action</th>
                                            <th>Date </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php $x=1;foreach($pic as $row){ ?>
                                            <tr>
                                            <td> <?php echo $x++; ?> </td>
                                            <td> <?php echo $row['username']; ?> </td>
                                            <td> <?php echo $row['action'];?></td>
                                            <td> <?php echo $row['datetime'];?> </td>
                                            </tr>
                                            <?php } ?>


                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->

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
        

    </div>
    <!-- /#page-wrapper -->

    <?php
    $modal_delete_data = array();
    $modal_delete_data["table_name"] = $delete_table_name;
    $this->load->view("modal/delete_confirmation", $modal_delete_data);
    ?>


    <!-- DataTables JavaScript -->
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

    </script>

<?php echo js("bulk_action.js"); ?>

<?php $this->load->view("element/footer"); ?>