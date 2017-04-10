<?php // item detail 

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
                        <a href="<?php echo base_url("send_email"); ?>" style="color: #3093E4;">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                    </span>
                    	
                        Send Email 
					
                    <span class="clearfix"></span>
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
                               
                               <div class="form-group col-md-4">
                               		<label> Name </label>
                                    <input type="text" class="form-control disabled" disabled value="<?=$dt["name"]?>">
                               </div>
                               
                               <div class="form-group col-md-4">
                               		<label> Email </label>
                                    <input type="text" class="form-control disabled" disabled value="<?=$dt["email_to"]?>">
                               </div>
                               <div class="form-group col-md-4">
                               		<label> Subject </label>
                                    <input type="text" class="form-control disabled" disabled value="<?=$dt["subject"]?>">
                               </div>
                               <span class="clearfix"></span>
                               
                               <hr>
                               
                               <?php // template email nya  ?>
                               <?=$template_email?>

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

        

    </div>
    <!-- /#page-wrapper -->

<?php echo js("bulk_action.js"); ?>

<?php $this->load->view("element/footer"); ?>