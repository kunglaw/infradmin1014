<?php
/**
 * Created by PhpStorm.
 * User: pulung
 * Date: 28/10/14
 * Time: 12:54
 */
?>

<?php $this->load->view("element/header_login"); ?>



<div class="login-box" style="padding-left: 5%; padding-right: 5%;">

    <div class="row" style="margin-bottom: 30px;">
        <div class="col-md-12" style="text-align: center;">
            <?php echo img("markplus_inc.png", array("style" => "width: 70%; height: auto;")); ?>
        </div>
    </div>

    <?php show_notification(); ?>

    <div class="row" style="margin-bottom: 10px;">
        <div class="col-md-12" style="text-align: center;">
            The page you requested is not exist.
        </div>
    </div>

</div>



<?php $this->load->view("element/footer_login"); ?>