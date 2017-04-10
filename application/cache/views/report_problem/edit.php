<?php
/**
 * Created by PhpStorm.
 * User: pulung
 * Date: 29/10/14
 * Time: 13:00
 */
?>
<?php $this->load->view("element/header"); ?>
	<script src="//tinymce.cachefly.net/4.3/tinymce.min.js"></script>
<script>tinymce.init({selector:'textarea'});</script>

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
                                        <form method="POST" action="<?=base_url();?>report_problem/proses_edit">

                                        <h3> Response Report </h3>
                                  

                                    <div class="form-group">
                                        <label> Solution Report </label>
                                        <textarea class="form-control" rows="10" cols="5" name="solution_report">
                                            <?php echo $report['solution_report']; ?>
                                         </textarea>
                                    </div>

                                    <div class="form-group">
                                        <label> Status </label>
                                             <select name="status_report" class="form-control" style="width:20%;">
                                                <?php if($report['status_report'] == "success"){ ?>
                                                     <option value="success"><strong> Success </strong> </option>
                                                  <option value="pending"> Pending </option>
                                                    <option value="failed"> Failed </option>       

                                                <?php } else if($report['status_report'] == "pending"){ ?>


                                                <option value="pending"> <strong> Pending </strong> </option>
                                                <option value="failed"> Failed </option>                                           
                                                     <option value="success"> Success </option>

                                                <?php }  else if($report['status_report'] == "failed") { ?>


                                                <option value="failed"> <strong> Failed </strong> </option>                                           
                                                     <option value="success"> Success </option>
                                                <option value="pending"> Pending </option>

                                                <?php } else { ?>
                                      <option value="failed"> Failed </option>                                           
                                                     <option value="success"> Success </option>
                                                <option value="pending"> Pending </option>                                                <?php }

                                                    ?> 
                                            </select>

                                    <input type="hidden" name="id_report" value="<?=$report['id_report'];?>">
       <span class="pull-left">
                      



                                    </div>

                                      <button type="submit" class="button-green-white ">

                            Done

                        </button>
                    </span>

                    <span>

                            <input type="reset" class="button-green-white ">
                <!--         <button type="reset" class="button-green-white ">

                            Reset 

                        </button> -->
                    </span>
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

        <!-- DataTables CSS -->
        <link href="<?php echo bower_url(); ?>datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

        <!-- DataTables Responsive CSS -->
        <link href="<?php echo bower_url(); ?>datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">

        
        <!-- /.row -->

  
                                                            </form>

        <!-- /.row -->

    </div>
    <!-- /#page-wrapper -->



    <!-- DataTables JavaScript -->
    <script src="<?php echo bower_url(); ?>datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo bower_url(); ?>datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    

<?php echo js("bulk_action.js"); ?>

<?php $this->load->view("element/footer"); ?>