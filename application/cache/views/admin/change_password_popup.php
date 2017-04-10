<?php
/**
 * Created by PhpStorm.
 * User: pulung
 * Date: 20/11/14
 * Time: 15:30
 */
?>



<div id="change-password-popup" class="white-popup mfp-hide" style="max-width: 300px;">
    <div class="row">
        <div class="col-md-12 popup-header popup-element-header">
            Change Password
        </div>
    </div>

    <div id="change-password-notification">
    </div>


    <?php echo form_open("admin/password/change", array("id" => "change-password-form")); ?>

    <?php echo form_hidden("id", $this->session->userdata("id")); ?>


    <div class="row" style="margin-bottom: 5px;">
        <div class="col-md-12">
            Old Password
        </div>
    </div>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-md-12">
            <?php
            echo form_password(
                array(
                    "name" => "old_password",
                    "class" => "col-md-12"
                )
            );
            ?>
        </div>
    </div>

    <div class="row" style="margin-bottom: 5px;">
        <div class="col-md-12">
            New Password
        </div>
    </div>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-md-12">
            <?php
            echo form_password(
                array(
                    "name" => "new_password",
                    "class" => "col-md-12"
                )
            );
            ?>
        </div>
    </div>

    <div class="row" style="margin-bottom: 5px;">
        <div class="col-md-12">
            New Password Confirmation
        </div>
    </div>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-md-12">
            <?php
            echo form_password(
                array(
                    "name" => "new_password_confirmation",
                    "class" => "col-md-12"
                )
            );
            ?>
        </div>
    </div>


    <div class="row" style="margin-bottom: 5px;">
        <div class="col-md-12" style="text-align: right;">
            <?php
            echo form_button(
                array(
                    "name" => "send",
                    "class" => "button-green-white ",
                    "type" => "submit"
                ),
                "Change"
            );
            ?>
        </div>
    </div>

    <?php echo form_close(); ?>
</div>

<script type="text/javascript">

    var changePasswordForm = $("form#change-password-form");
    var changePasswordPopup = $("#change-password-popup");

    /**
     * Prepare edit form, assign value to form input,
     * clearing previous data.
     */
    function prepareChangePassword() {

        clickedElement = $(".change-password-button-return-action");
        $(".error-wrapper").remove();

        changePasswordPopup.find(".popup-element-header").html("Change Password");
        changePasswordForm.find("input[name=send]").val("Save");
        $("#change-password-notification").html("");
    }

    $(document).ready(function() {

        // register triggers for magnific popup
        $(".change-password-button, .change-password-button-return-action").magnificPopup({
            closeOnBgClick: false
        });

        $(".change-password-button").click(prepareChangePassword);


        changePasswordForm.find("button[name=send]").click(function() {
            $(".error-wrapper").remove();

            var uploadOptions = {
                beforeSubmit: function() {

                    var loadingImageObject = changePasswordForm.find("button[name=send]").prev("img");
                    loadingImageObject.remove();

                    changePasswordForm.find("button[name=send]").prop("disabled", true);
                    changePasswordForm.find("button[name=send]").removeClass("button-turqoise-white");
                    changePasswordForm.find("button[name=send]").addClass("button-grey-white");

                    var loadingImage = '<img src="<?php echo img_url(); ?>loading.gif">&nbsp;';
                    changePasswordForm.find("button[name=send]").before(loadingImage);
                },
                success: function(data) {

                    changePasswordForm.find("button[name=send]").prop("disabled", false);
                    changePasswordForm.find("button[name=send]").removeClass("button-grey-white");
                    changePasswordForm.find("button[name=send]").addClass("button-turqoise-white");
                    changePasswordForm.find("button[name=send]").prev().remove();

                    var result = data;
                    if (result.status == "error") {

                        $("#change-password-notification").html(result.notification);

                        var openWrapper = '<div class="row error-wrapper"><div class="col-md-12">';
                        var closeWrapper = '</div></div>';

                        $.each(result.errors, function(index, value) {

                            $("[name="+ index +"]").closest(".row").before(
                                openWrapper + value + closeWrapper);

                        });

                    } else {

                        location.reload();
                    }
                }
            };

            changePasswordForm.ajaxForm(uploadOptions);
            changePasswordForm.submit();

            return false;
        });
    });
</script>