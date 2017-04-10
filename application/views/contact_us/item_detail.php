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
                                            <td> ID Contact </td>
                                            <td> : </td>
                                            <td> <?php echo $contact['id_contact'];?> </td>
                                        </tr>
                                        <tr>
                                            <td> Nama Pengirim </td>
                                            <td> : </td>
                                            <td> <?php echo $contact['nama_pengirim']; ?> </td>
                                        </tr>
                                        <tr>
                                            <td> Email </td>
                                            <td> : </td>
                                            <td> <?php echo $contact['email'];?> </td>
                                        </tr>
                                        <tr>
                                            <td> Subject </td>
                                            <td> : </td>
                                            <td> <?php echo $contact['subject']; ?> </td>
                                        </tr>
                                        <tr>
                                            <td> Message </td>
                                            <td> : </td>
                                            <td> <?=$contact['message'];?> </td>
                                        </tr> </tbody>
                                </table>

                            </div>
                            <br>



                        </div>

                        <br><br>
                         <div class="row">
                            <div class="col-md-12">
                                <h3> Repply Message

                                    
                                 </h3>
                                <table class="company-detail">
                                    <thead class="button-green-white">
                                  
                                    </thead>
                                    <tbody>
                          <form enctype="multipart/form-data" method="POST" action="<?php echo base_url();?>contact_us/repply_message">

                                        <tr>
                                            <td valign="top"> Subject </td>
                                            <td width="2%;"> : </td>
                                            <td> <input type="text" name="subject" class="form-control"> </td>
                                        </tr>
                                     <tr>
                                            <td valign="top"> Reply Message </td>
                                            <td valign="top"> : </td>
                                            <td> 

                                                    <textarea class="form-control" rows="10" name="messagenew" value=""> 

                                                    </textarea>
                                                    <input type="hidden" name="id_contact" value="<?=$contact['id_contact'];?>">
                                                    <input type="hidden" name="email" value="<?=$contact['email'];?>">
                                                    <br>
                                                    <button type="submit" class="btn btn-primary pull-right"> Send </button>
                                            </form>


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