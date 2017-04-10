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
                        <a href="<?php echo base_url(); ?>seatizen" style="color: #3093E4;">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                    </span>
                    SEATIZEN DETAIL

                    <span class="pull-right">

                        <?php if ($activation == "ACTIVE"): ?>

                            <a href="#" class="block-one-button button-green-white"
                               data-toggle="modal" data-target="#block-one-confirmation"
                               style="margin-right: 10px;">

                                Block
                            </a>
                            <input type="hidden" class="object-id" value="<?php echo $item_id; ?>">

                        <?php else: ?>

                            <a href="#" class="unblock-one-button button-green-white"
                                data-toggle="modal" data-target="#unblock-one-confirmation"
                                style="margin-right: 10px;">

                                Unblock
                            </a>
                            <input type="hidden" class="object-id" value="<?php echo $item_id; ?>">

                        <?php endif; ?>

                        <a href="<?php echo base_url() ."seatizen/log/". $item_id; ?>" class="button-green-white ">
                            Seatizen Log
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

                        <div class="col-md-2">

                            <img src="<?php echo $photo; ?>" style="width: 100%;" onerror="handleUserImageError(this)" />

                        </div>

                        <div class="col-md-10">

                            <?php if ($detail_available): ?>

                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-md-2">
                                        Name
                                    </div>
                                    <div class="col-md-10">
                                        <?php echo $nama_depan." ".$nama_belakang; ?> 

                                        <a href="http://informasea.com/profile/<?php echo $username;?>/resume" target="_blank"> View Resume </a>
                                    </div>
                                </div>

                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-md-2">
                                        Rank
                                    </div>
                                    <div class="col-md-10">
                                        <?php echo $rank_name; ?>
                                    </div>
                                </div>

                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-md-2">
                                        National
                                    </div>
                                    <div class="col-md-10">
                                        <?php echo $kebangsaan; ?>
                                    </div>
                                </div>

                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-md-2">
                                        Religion
                                    </div>
                                    <div class="col-md-10">
                                        <?php echo $agama; ?>
                                    </div>
                                </div>

                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-md-2">
                                        Gender
                                    </div>
                                    <div class="col-md-10">
                                        <?php echo $gender; ?>
                                    </div>
                                </div>

                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-md-2">
                                        Birth Place
                                    </div>
                                    <div class="col-md-10">
                                        <?php echo $tempat_lahir; ?>
                                    </div>
                                </div>

                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-md-2">
                                        Birth Date
                                    </div>
                                    <div class="col-md-10">
                                        <?php echo $tanggal_lahir; ?>
                                    </div>
                                </div>

                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-md-2">
                                        Address
                                    </div>
                                    <div class="col-md-10">
                                        <?php echo $alamat; ?>
                                    </div>
                                </div>

                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-md-2">
                                        Phone
                                    </div>
                                    <div class="col-md-10">
                                        <?php echo $telepon; ?>
                                    </div>
                                </div>

                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-md-2">
                                        Email
                                    </div>
                                    <div class="col-md-10">
                                        <?php echo $email; ?>
                                    </div>
                                </div>

                              <!--   <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-md-2">
                                        Status
                                    </div>
                                    <div class="col-md-10">
                                        <?php //echo $crew_status; ?>
                                    </div>
                                </div> -->
                                <div class="row" style="margin-bottom:10px;">
                                    <div class="col-md-2">
                                        Join Since
                                    </div>
                                    <div class="col-md-10">
                                        <?php echo $create_date;  ?>
                                    </div>

                                </div>
                                
                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-md-2">
                                        Register From 
                                    </div>
                                    <div class="col-md-10">
                                        <?php echo $register_from; ?>
                                    </div>
                                </div>


                            <?php else: ?>

                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-md-12">
                                        Seatizen is not a crew, crew detail is not available.
                                    </div>
                                </div>

                            <?php endif; ?>

                        </div>

                        <div style="clear:both;"> </div>
                             <div class="col-md-4" style="margin-top:30px;">
                        <h3 class="page-header">  Total View Seatizen </h3>
                            <table class="company-detail table table-bordered">
                                <tr>
                                    <td width="50%"><strong> Total View  </strong></td>
                                    <td width="2%"> : </td>
                                    <td> <?php echo $jumlah_view; ?> </td>
                                </tr>
                                </table>
                                <br>
                                <br>
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
    $modal_block_data = array();
    $modal_block_data["route"] = $block_route;
    $this->load->view("modal/block_confirmation", $modal_block_data);
    $this->load->view("modal/unblock_confirmation", $modal_block_data);
    ?>

<?php $this->load->view("element/footer"); ?>