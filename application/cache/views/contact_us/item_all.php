<?php
/**
 * Created by PhpStorm.
 * User: pulung
 * Date: 29/10/14
 * Time: 13:00
 */
?>
<?php $this->load->view("element/header"); ?>

    <!-- DataTables CSS -->
    <link href="<?php echo bower_url(); ?>datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="<?php echo bower_url(); ?>datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">
    <div id="modal-edit-report"></div>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header">

                        <span>
                        <a href="<?php echo base_url(); ?>contact_us" style="color: #3093E4;">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                    </span>

                   Contact Us

                </h1>
            </div>
            <!-- /.col-md-12 -->
        </div>
        <!-- /.row -->    

    <?php include "js_top.php" ?>

        <?php show_notification(); ?>

        <div class="modal-edit-pic"> </div>

        <div class="row">
            <div class="modal-edit-report"> </div>
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
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-list">
                                        <thead class="button-green-white">
                                        <tr>
                                            <th>Id</th>
                                            <th>Name </th>
                                            <th>Email </th>
                                            <th>Subject </th>
                                            <th>Message</th>
                                            <th>Waktu Pengirim </th>
                                            <th>Repply By  </th>
                                            <th> Action</th>
                                        </tr>
                                        </thead>
                                        <tbody> 
                                            <?php 
                                            $this->load->model('contact_model');
                                            foreach($contact as $row){

                                             ?>
                                            <tr>
                                                <td> <?=$row['id_contact'];?></td>
                                                <td> <?=$row['nama_pengirim'];?></td>
                                                <td> <?=$row['email'];?></td>
                                                <td> <?=$row['subject'];?> </td>
                                                <td> <?=$row['message']; ?> </td>
                                                <td>                                             
                                                 <?=$row['waktu_pengirim']; ?>

                                                </td>
                                                <td> 
                                                    <?=$row['reply_by']; ?>
                                            
                                                </td>
                                                <td>

                                            <!--   <i class="fa fa-bars"></i>
                                                &nbsp;&nbsp; -->
                                                <?php if($row['reply_by'] != ""){ 
                                                    ?>
                                                    <a href="<?php echo base_url();?>contact_us/detail/<?php echo $row['id_contact'];?>"> <i class="fa fa-bars"> </i> </a>

                                                    <?php 
                                                }else{   ?>
                                                <a href="<?php echo base_url();?>contact_us/reply_item/<?php echo $row['id_contact'];?>">
                                                <i class="fa fa-edit"> </i>
                                            </a>
                                            <?php } ?>

                                                        </td>
                                            </tr>
                                        </tbody>
                                            <?php } ?>
                                    </table>


                                        <br>    
                                

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
            pageLength: 10,
            dom: '<"H"r>t<"F"ip>',
            order: [
                [1, 'desc']
            ],
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
        
            
            
            oTable = $('#dataTables-list').DataTable(settings);

            $("input[name=filter_1]").on("keyup change", function () {
                oTable.column(1).search($(this).val()).draw();
            });

            $("input[name=filter_2]").on("keyup change", function () {
                oTable.column(2).search($(this).val()).draw();
            });
            
            
        });

    </script>


    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>

    </script>

<?php echo js("bulk_action.js"); ?>

<?php $this->load->view("element/footer"); ?>