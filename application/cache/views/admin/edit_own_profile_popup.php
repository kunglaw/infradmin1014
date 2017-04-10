<?php
/**
 * Created by PhpStorm.
 * User: pulung
 * Date: 20/11/14
 * Time: 15:30
 */
?>



<div id="edit-own-profile-popup" class="white-popup mfp-hide" style="max-width: 300px;">
    <div class="row">
        <div class="col-md-12 popup-header popup-element-header">
           baba
        </div>
    </div>

    <div id="create-edit-notification">
    </div>

				<?php // access/edit_own ?>
    <?php echo form_open("admin/own/edit", array("id" => "user-edit-own-form")); ?>

    <?php echo form_hidden("id", $this->session->userdata("id")); ?>


    <div class="row" style="margin-bottom: 5px;">
        <div class="col-md-12">
            Nama
        </div>
    </div>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-md-12">
            <?php
            echo form_input(
                array(
                    "name" => "name",
                    "class" => "col-md-12"
                )
            );
            ?>
        </div>
    </div>


    <div class="row" style="margin-bottom: 5px;">
        <div class="col-md-12">
            Email
        </div>
    </div>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-md-12">
            <?php
            echo form_input(
                array(
                    "name" => "email",
                    "class" => "col-md-12",
                    "disabled" => "disabled"
                )
            );
            ?>
        </div>
    </div>

    <div class="row" style="margin-bottom: 5px;">
        <div class="col-md-12">
            Role
        </div>
    </div>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-md-12">
            <?php
            echo form_input(
                array(
                    "name" => "role",
                    "class" => "col-md-12",
                    "disabled" => "disabled"
                )
            );
            ?>
        </div>
    </div>

    <div class="row" style="margin-bottom: 5px;">
        <div class="col-md-12">
            Profile Picture
        </div>
    </div>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-md-12">
            <?php
            $this->load->view("element/part_image_cropper",
                array("cropper_id" => "crop-thumbnail-edit-profile"));
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
                "Edit"
            );
            ?>
        </div>
    </div>

    <?php echo form_close(); ?>
</div>

<script type="text/javascript">

    /**
     * Prepare edit form, assign value to form input,
     * clearing previous data.
     */
    function prepareEditOwnProfileForm() {

        clickedElement = $(".edit-own-profile-button-return-action");
        $(".error-wrapper").remove();

        var formSelector = $("form#user-edit-own-form");
        var baseURL = "<?php echo base_url(); ?>";
        var userID = $(this).next("input.user-id").val();

        $(".popup-element-header").html("Edit Profile");
        formSelector.find("input[name=send]").val("Save");
        $("#create-edit-notification").html("");

        formSelector.find("input[name=email]").prop("disabled", "disabled");

        // ajax call to get user data
        $.ajax({
            dataType: "json",
            type: "POST",
            data: {csrf_token: bulkActionCSRFValue},
            url: baseURL + "admin/own/detail/ajax",
            success: function(data) {

                // apply user detail to form input
                formSelector.find("input[name=name]").val(data.name);
                formSelector.find("input[name=email]").val(data.email);
                formSelector.find("input[name=role]").val(data.role_name);

                if (! (data.image == "" || data.image == null)) {

                    var time = new Date().getTime();

                    formSelector.find(".thumbnail-view").html(
                        '<img src="'+ data.image + '?' + time +'" />'
                    );
                } else {
                    //  reset image placeholder
                    $(".thumbnail-view").html("+");
                    $(".thumbnail-view").css("line-height", "240px");
                }
            }
        });

        // change form action
        formSelector.prop("action", baseURL + "admin/own/edit");
    }

    $(document).ready(function() {

        var formSelector = $("form#user-edit-own-form");

        $(".edit-own-profile-button").click(prepareEditOwnProfileForm);


        formSelector.find("button[name=send]").click(function() {

            $(".error-wrapper").remove();

            var uploadOptions = {
                beforeSubmit: function() {

                    var loadingImageObject = formSelector.find("button[name=send]").prev("img");
                    loadingImageObject.remove();

                    formSelector.find("button[name=send]").prop("disabled", true);
                    formSelector.find("button[name=send]").removeClass("button-turqoise-white");
                    formSelector.find("button[name=send]").addClass("button-grey-white");

                    var loadingImage = '<img src="<?php echo img_url(); ?>loading.gif">&nbsp;';
                    formSelector.find("button[name=send]").before(loadingImage);
                },
                success: function(data) {

                    var result = data;
                    if (result.status == "error") {

                        $("#create-edit-notification").html(result.notification);

                        var openWrapper = '<div class="row error-wrapper"><div class="col-md-12">';
                        var closeWrapper = '</div></div>';

                        $.each(result.errors, function(index, value) {

                            $("[name="+ index +"]").closest(".row").before(
                                openWrapper + value + closeWrapper);

                        });

                    } else {

                        location.reload();
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            };

            formSelector.ajaxForm(uploadOptions);
            formSelector.submit();

            return false;
        });


        $(document).ready(function() {

            $("#crop-thumbnail-edit-profile .thumbnail-view").click(function() {
                $(".thumbnail-form .thumbnail-input").click();
            });

            $("#crop-thumbnail-edit-profile .thumbnail-upload-button").click(function() {
                $(".thumbnail-form .thumbnail-save").click();
            });

        });
    });
</script>