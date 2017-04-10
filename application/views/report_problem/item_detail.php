<?php
/**
 * Created by PhpStorm.
 * User: pulung
 * Date: 29/10/14
 * Time: 13:00
 */
?>
<?php $this->load->view("element/header"); ?>
	
    <div id="page-wrapper">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header">
                    <span>
                        <a href="<?php echo base_url(); ?>report_problem" style="color: #3093E4;">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                    </span>
                

                    REPORT PROBLEM

                </h1>
            </div>
            <!-- /.col-md-12 -->
        </div>
        <!-- /.row -->

    <div id="modal-edit-report"></div>

        <div class="row">

            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">

                                <table class="company-detail">
                                    <thead class="button-green-white">
                                  
                                    </thead>
                                    <tbody>

                                    <tr>
                                        <td>Id Report</td>
                                        <td> <?=$report['id_report'];?></td>
                                    </tr>

                                    <tr>
                                        <td>Username Pengirim </td>
                                        <td> 

                                            <?php 
                                            $this->load->model('report_model');
                                            if($report['type_pengirim'] == "company"){
                                                $user = $this->report_model->detail_company($report['id_user']);
                                            }else {
                                                $user = $this->report_model->detail_username($report['id_user']);
                                               
                                               }


                                           echo  $user['username']; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Waktu</td>
                                        <td> <?=$report['time'];?></td>
                                    </tr>

                                    <tr>
                                        <td>Kategori</td>
                                        <td> <?=$report['kategori'];?></td>
                                    </tr>

                                    <tr>
                                        <td>Pesan </td>
                                        <td> <?=$report['pesan'];?></td>
                                    </tr>

                                    <tr>
                                        <td> Gambar </td>
                                        <?php 
                                        $url = IMG_REPORT."report/".$report['gambar_report'];
                                        ?>

                                        <td>  <img src="<?=$url;?>"> </td>
                                    </tr>


                                    <tr>
                                        <td>PIC</td>
                                        <td> <?=$report['pic']; ?> </td>
                                    </tr>



                                    <tr>
                                        <td>Solution Report </td>
                                        <td> <?=$report['solution_report']; ?> </td>
                                    </tr>

                                    <tr>
                                        <td>Status</td>
                                        <td> <?=$report['status_report']; ?></td>
                                    </tr>

                                    </tbody>
                                </table>

                            </div>
                            <br>



                        </div>

                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-md-12 -->
            <div class="col-md-12">
              <h3 class="page-header"> History </h3>
                            <table class="company-detail table table-bordered">
                                <thead class="button-green-white">
                                      <th> No </th>
                                    <th> PIC </th>
                                    <th> Superadmin </th>
                                    <th> Solution Report </th>
                                    <th> Assigned Date </th>
                                    </thead>
                                
                                <?php 
                                $no = 1;
                                    foreach($history as $row){ ?>

                                    <tr>
                                        <td> <?=$no++;?> </td>
                                        <td> <?=$row['pic'];?></td>
                                        <td> <?=$row['superadmin'];?></td>
                                        <td> <?=$row['solution_report'];?></td>
                                        <td> <?=$row['waktu'];?> </td>
                                    </tr>

                                    <?php } ?>

                                </table>
                                <br>
                                <br>
                            </div>
        </div>
        <!-- /.row -->

        <!-- DataTables CSS -->
        <link href="<?php echo bower_url(); ?>datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

        <!-- DataTables Responsive CSS -->
        <link href="<?php echo bower_url(); ?>datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">

        
        <!-- /.row -->

  <!--        <span class="pull-left">
                        <a href="<?php //echo base_url() ."report_problem/edit_report/".$report['id_report'] ?>" class="button-green-white ">

                            Edit

                        </a>
                    </span> -->
        <!-- /.row -->

    </div>
    <!-- /#page-wrapper -->



    <!-- DataTables JavaScript -->
    <script src="<?php echo bower_url(); ?>datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo bower_url(); ?>datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    

<?php echo js("bulk_action.js"); ?>

<?php $this->load->view("element/footer"); ?>