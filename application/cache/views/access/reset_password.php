<?php
/**
 * Created by PhpStorm.
 * User: pulung
 * Date: 28/10/14
 * Time: 12:54
 */
?>

<?php $this->load->view("element/header_login"); ?>

<div class="row" style="margin: auto;">
    <div class="
            col-lg-4 col-lg-offset-4
            col-md-4 col-md-offset-4
            col-sm-4 col-sm-offset-4
            col-xs-12 col-xs-offset-0
            login-box"
         style="padding-left: 2%; padding-right: 2%;">

        <?php
        echo form_open("password/reset");
        echo form_hidden("token", $token);
        ?>

        <div class="row" style="margin-bottom: 30px;">
            <div class="col-md-12" style="text-align: center;">
                <?php echo img("logo-white.png", array("style" => "width: 70%; height: auto;")); ?>
            </div>
        </div>

        <?php show_notification(); ?>

        <div class="row input-box">
            <div class="row">
                <div class="col-md-12">
                    Password
                </div>
            </div>

            <div class="row" style="margin-bottom: 10px;">
                <div class="col-md-12">
                    <?php
                    echo form_password(
                        array(
                            "name" => "password",
                            "class" => "col-xs-12 button-white-transparent",
                            "style" => "font-size: 10pt;"
                        )
                    );
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    Password Confirmation
                </div>
            </div>

            <div class="row" style="margin-bottom: 10px;">
                <div class="col-md-12">
                    <?php
                    echo form_password(
                        array(
                            "name" => "password_confirmation",
                            "class" => "col-xs-12 button-white-transparent",
                            "style" => "font-size: 10pt;"
                        )
                    );
                    ?>
                </div>
            </div>



            <div class="row">
                <div class="col-md-12">
                    <?php
                    echo form_submit(
                        array(
                            "name" => "login",
                            "class" => "col-xs-12 button-green-white",
                            "value" => "Change Password"
                        )
                    );
                    ?>
                </div>
            </div>
        </div>


        <?php echo form_close(); ?>

    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("input[name=password]").focus();
    });
</script>



<?php $this->load->view("element/footer_login"); ?>