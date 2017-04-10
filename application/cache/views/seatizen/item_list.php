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

<form action="<?=base_url("seatizen/import")?>" id="form-upload-seatizen" style="display:none" method="post" enctype="multipart/form-data" >  
	<input type="file" name="excel_file" id="seatizen_dtexcel" />
    <input type="submit" name="submit" id="submit" />
 
</form>

    <!-- DataTables CSS -->
    <link href="<?php echo bower_url("datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css"); ?>" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="<?php echo bower_url("datatables-responsive/css/dataTables.responsive.css"); ?>" rel="stylesheet">
<div id="modal-block-seatizen"></div>
    <script>
    function blockSeatizen (id_seatizen) {
        // body...\
        // alert("im clicked "+id_seatizen);
        $.ajax({
            type:"POST",
            data:"x=1&pelaut_id="+id_seatizen,
            url:"<?=base_url("seatizen/FormBlockSeatizen")?>",
            success:function(data){
                
                $("#modal-block-seatizen").html(data);
            }
        });
    }
    </script>
    
    <div id="page-wrapper">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header">
                    SEATIZEN MANAGEMENT                    
                    
                    <span class="pull-right">
                    	
                        <a href="<?php echo base_url("seatizen/download_excel_template") ?>"
                        class="button-green-white"
                        style="margin-right: 10px;">

                        <i class="fa fa-arrow-circle-down"></i>
                        Download Template
                        </a>
    
                        <a href="#import-popup" class="button-green-white" id="import-popup" style="margin-right:10px;">
                            <i class="fa fa-cloud-upload"></i>
                            Import Seatizen Data
                        </a>
                        
                        <a href="<?php echo base_url(); ?>seatizen/dashboard" class="button-green-white">
                            <i class="fa fa-line-chart"></i>
                            Seatizen Growth
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
                                echo form_button(
                                    array(
                                        "class" => "button-green-white ",
                                        "data-toggle" => "modal",
                                        "data-target" => "#block-many-confirmation"
                                    ),
                                    "Block"
                                );
                                ?>

                                <?php
                                echo form_button(
                                    array(
                                        "class" => "button-green-white ",
                                        "data-toggle" => "modal",
                                        "data-target" => "#unblock-many-confirmation"
                                    ),
                                    "Unblock"
                                );
                                ?>

                                <?php
                                echo form_input(
                                    array(
                                        "class" => "search",
                                        "name" => "filter_1",
                                        "placeholder" => "Name"
                                    )
                                );
                                ?>

                                <?php
                                echo form_input(
                                    array(
                                        "class" => "search",
                                        "name" => "filter_2",
                                        "placeholder" => "Email"
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
                                            <th style="text-align: center;"><input type="checkbox" onclick="cek_all()" id="cek_all" name="id_all"></th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Department</th>
                                            <th>Gender</th>
                                            <th>Last Login</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        
                                            foreach ($list_seatizen as $dt) {
                                                # code...

                                                $dtLastLogin = $this->seatizen->lastLoginSeatizen($dt['username']);
                                                // print_r($dtLastLogin);
                                                // echo $dtLastLogin['action_time'];
                                                $dtCrew = $this->seatizen->ViewSeatizenCrew($dt['pelaut_id']);
                                                // print_r($dtCrew)
                                                $department_seatizen = "-";
                                                $arr_dept = array();
                                                $arr_comp = array();
                                                $z=0;
                                                foreach ($dtCrew as $crew) {
                                                    # code...
                                                    $dt_department = $this->department->get_detail_department($crew['department']);
                                                    $dt_company = $this->seatizen->CompanySeatizen($crew['id_perusahaan']);
                                                    if($z==0)$department_seatizen = "- $dt_department[department] ($dt_company[nama_perusahaan])";
                                                    
                                                    else
                                                    $department_seatizen .= "<br>- $dt_department[department] ($dt_company[nama_perusahaan])";
                                                    $z++;
                                                    
                                                }
                                                $status = $dt["activation"];
                                                $class = "style='background-color: orange'";
                                                if($status == "BLOCKED")
                                                {
                                                    $class = "style='background-color: #FF2865; color: black;'";
                                                    $block_state = "glyphicon glyphicon-ok-sign"; $title_block = "unblock";

                                                }
                                                else if($status == "ACTIVE"){
                                                    $class = "";
                                                    $block_state = "glyphicon glyphicon-ban-circle"; $title_block = "block";
                                                }

                                                $data_content = "<div> PIC :  </div>".
                                                "<div> on:  </div> ";
                                                $title_popup = $dt['activation'];
                                                if($dt['activation'] != "ACTIVE" && $dt['activation'] != "BLOCKED"){
                                                    $title_popup = "ACTIVATION CODE";
                                                }

                                                ?>

                                            <tr <?= $class ?>>
                                              <td class="center reference" >
                                                    <input type="checkbox" name="list_checkboxes[]" value="<?=$dt['pelaut_id']?>">
                                                    <span data-toggle="popover" data-content="<?=$data_content?>" 
                                                    title="<?=$title_popup?>" class="ipop"></span>
                                              </td>
                                              <td class="left name" >
                                                <div data-toggle="popover" class="ipop pull-left" data-content="<?=$data_content?>" 
                                                title="<?=$title_popup?>">
                                                    <?=$dt['nama_depan']." ".$dt['nama_belakang']?>                                          
                                                </div>
                                              </td>
                                              <td class="left linkable" >
                                                <div data-toggle="popover" class="ipop" data-content="<?=$data_content?>"
                                                title="<?=$title_popup?>"> 
                                                <?=$dt['email']?> </div>
                                              </td>
                                              <td class="left linkable" >
                                                <div data-toggle="popover" class="ipop" data-content="<?=$data_content?>"
                                                title="<?=$title_popup?>"> 
                                                <?=$department_seatizen?> </div>
                                              </td>
                                              <td class="left linkable" >
                                                <div data-toggle="popover" class="ipop" data-content="<?=$data_content?>"
                                                title="<?=$title_popup?>"> 
                                                <?=$dt['gender']?> </div>
                                              </td>
                                              <td class="left linkable">
                                                <div data-toggle="popover" class="ipop" data-content="<?=$data_content;?>"
                                                    title="<?=$title_popup;?>">
                                                    <?php 
                                                if(count($dtLastLogin) != 0){ 
                                                    $xzzz = date('Y-m-d H:i:s');
                                                    $now = new DateTime($xzzz);
                                                    $terakhir = new DateTime($dtLastLogin['action_time']);
                                                    // echo $dtLastLogin['action_time'];
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
                                              <td align="center">
                                                  <a href="<?=base_url("agentsea/log/$dt[pelaut_id]")?>">
                                                  <i class="fa fa-bars"></i>
                                                  </a>
                                             <?php if($dt['activation'] == "ACTIVE" || $dt['activation'] == "BLOCKED"){
                                                    ?>
                                                    <a href='#' onclick='blockSeatizen(<?=$dt['pelaut_id']?>)' >
                                                    <i class="<?php echo $block_state ?>" title="<?php echo $title_block ?>"></i>
                                                </a>
                                                    <?php
                                                } ?>
                                                
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


    <?php
    $modal_block_data = array();
    $modal_block_data["route"] = $controller_name;
    $this->load->view("modal/block_confirmation", $modal_block_data);
    $this->load->view("modal/unblock_confirmation", $modal_block_data);
    ?>

    

    <!-- DataTables JavaScript -->
    <script src="<?php echo bower_url(); ?>datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo bower_url(); ?>datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>


    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>

        function cek_all () {
                // body...
                var state = $("#cek_all").prop("checked");
                $("#dataTables-list").parent().find(".reference").find("input[name=list_checkboxes\\[\\]]").prop("checked", state);
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
            // ajax: {
            //     url: source,
            //     type: "POST",
            //     data: function(data) {
            //         data.token_field = csrfHash;
            //     }
            // },
            // serverSide: true,
            lengthChange: false,
            columnDefs:[{orderable: false, targets: [0]}],
            searching: true,
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
            drawCallback: function() {


                listCheckboxes = {};
                $("input[name=id_all]").prop("checked", false);
            }
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
                var reference = $(this).parent().find(".reference").find("input[name=list_checkboxes\\[\\]]").val();
                document.location.href = baseURL + controllerName + "/detail/page/" + reference;
            });
			
			// trigger file upload to show.
            $("#import-popup").click(function() {
                $("input[name=excel_file]").click();
            });

            $("input[name=excel_file]").change(function() {

                if ($(this).val() != "") {

                    var uploadOptions = {
                        success: function(data) {
							
							//alert(data);
							
                            var result = data;

                            if (result.status == "error") {

                                showNotification("danger", result.notification);

                            } else {

                                showNotification("success", result.notification);

                                // redraw datatable,
                                oTable.draw();
                            }
                        },
                        error: function(data) {

                            console.log(data);
                            showNotification("danger", result.notification);
//                            location.reload();
                        }
                    };

                    $("#form-upload-seatizen").ajaxForm(uploadOptions);
                    $("#form-upload-seatizen").submit();


                    $(this).val("");

                    return false;
                }
            });
        });

    </script>

<?php echo js("bulk_action.js"); ?>

<?php $this->load->view("element/footer"); ?>