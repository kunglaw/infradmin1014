<?php
/**
 * Created by PhpStorm.
 * User: pulung
 * Date: 13/11/14
 * Time: 10:24
 */
?>

<div id="create-edit-popup" class="white-popup mfp-hide"
     style="max-width: <?php echo (isset($popup_width) ? $popup_width : 300 ); ?>px;">

    <div class="row">
        <div class="col-md-12 popup-header popup-element-header">
            <?php echo $initial_name; ?>
        </div>
    </div>

    <div id="create-edit-notification">
    </div>

    <?php
    if (isset($form_is_multipart) && $form_is_multipart == TRUE) {

        echo form_open_multipart($action_target, array("id" => "create-edit-form"));

    } else {

        echo form_open($action_target, array("id" => "create-edit-form"));
    }
    ?>


    <?php
    if ($popup_location != "") {
        $this->load->view($popup_location);
    }
    ?>

    <?php echo form_close(); ?>


</div>

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>

    $(document).ready(function () {

        var formSelector = $("form#create-edit-form");

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

                    formSelector.find("button[name=send]").prop("disabled", false);
                    formSelector.find("button[name=send]").removeClass("button-grey-white");
                    formSelector.find("button[name=send]").addClass("button-turqoise-white");

                    formSelector.find("button[name=send]").prev().remove();

                    var result = data;
//                    console.log(data);

                    if (result.status == "error") {

                        $("#create-edit-notification").html(result.notification);

                        var openWrapper = '<div class="row error-wrapper"><div class="col-md-12">';
                        var closeWrapper = '</div></div>';

                        $.each(result.errors, function(index, value) {

                            // check if input has [ and ] selector
                            var openSquareBracketIndex = index.indexOf("[");
                            var closeSquareBracketIndex = index.indexOf("]");

                            if (openSquareBracketIndex != -1 || closeSquareBracketIndex != -1) {

                                index = index.replace("[", "\\[");
                                index = index.replace("]", "\\]");
                            }

                            $("[name="+ index +"]").closest(".row").before(
                                openWrapper + value + closeWrapper);

                        });

                    } else {

                        // redraw datatable
                        oTable.draw();

                        $.magnificPopup.close();
                        showNotification("success", result.notification);

                    }
                },
                error: function(data) {

//                    console.log(data);

                    formSelector.find("button[name=send]").prop("disabled", false);
                    formSelector.find("button[name=send]").removeClass("button-grey-white");
                    formSelector.find("button[name=send]").addClass("button-turqoise-white");

                    var errorMessage = '<div class="row">'+
                        '<div class="col-md-12">'+
                        '<div class="alert alert-danger alert-dismissible">'+
                        '<div class="sub-alert-danger">'+
                        'An error occured. Please try again'+
                        '</div></div></div></div>';

                    $("#create-edit-notification").html(errorMessage);

//                    location.reload();
                }
            };

            formSelector.ajaxForm(uploadOptions);
            formSelector.submit();

            return false;
        });

        $("input[name=" + bulkActionCSRFToken + "]").val(bulkActionCSRFValue);
    });
</script>