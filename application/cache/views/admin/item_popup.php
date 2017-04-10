<?php
/**
 * Created by PhpStorm.
 * User: pulung
 * Date: 13/11/14
 * Time: 10:53
 */
?>

<?php
echo form_hidden("id");
?>

<div class="row" style="margin-bottom: 5px;">
    <div class="col-md-12">
        Name
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
                "class" => "col-md-12"
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
        echo form_dropdown(
            "role",
            $role_list,
            1,
            'class="col-md-12"'
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
            array("cropper_id" => "crop-thumbnail-common"));
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
            "Submit"
        );
        ?>
    </div>
</div>



<script type="text/javascript">

    var clickedElement;
    var controllerName = "<?php echo $controller_name; ?>";
    var createPopupHeader = "<?php echo isset($create_popup_header) ? $create_popup_header : ""; ?>";
    var createPopupSubmit = "<?php echo isset($create_popup_submit) ? $create_popup_submit : ""; ?>";
    var editPopupHeader = "<?php echo isset($edit_popup_header) ? $edit_popup_header : ""; ?>";
    var editPopupSubmit = "<?php echo isset($edit_popup_submit) ? $edit_popup_submit : ""; ?>";

    /**
     * Prepare create form, reset all previous data.
     */
    function prepareCreateForm() {
        clickedElement = $(".create-button-no-reset");
        $(".error-wrapper").remove();

        var formSelector = $("form#create-edit-form");
        var baseURL = "<?php echo $base_url; ?>";

        $(".popup-element-header").html(createPopupHeader);
        formSelector.find("button[name=send]").html(createPopupSubmit);
        $("#create-edit-notification").html("");

        //  reset image placeholder
        $(".thumbnail-view").html("+");
        $(".thumbnail-view").css("line-height", "240px");

        // clear all input in create-edit-form
        formSelector.find("input").not("input[type=submit], input[name=token_field], input[name=csrf_token]").val("");
        formSelector.find("input[name=email]").prop("disabled", "");
        formSelector.find("select").val(1);

        // change form action
        formSelector.prop("action", baseURL + controllerName + "/add");

    }

    /**
     * Prepare edit form, assign value to form input,
     * clearing previous data.
     */
    function prepareEditForm() {

        clickedElement = $(".edit-button-return-action");
        $(".error-wrapper").remove();

        var formSelector = $("form#create-edit-form");
        var baseURL = "<?php echo $base_url; ?>";
        var objectID = $(this).next("input.object-id").val();

        $(".popup-element-header").html(editPopupHeader);
        formSelector.find("button[name=send]").html(editPopupSubmit);
        $("#create-edit-notification").html("");

        formSelector.find("input").not("input[type=submit], input[name=token_field], input[name=csrf_token]").val("");
        formSelector.find("input[name=email]").prop("disabled", "disabled");

        // ajax call to get object data
        $.ajax({
            dataType: "json",
            type: "POST",
            data: {csrf_token: bulkActionCSRFValue},
            url: baseURL + controllerName + "/detail/ajax/" + objectID,
            success: function(data) {

                // apply user detail to form input
                formSelector.find("input[name=id]").val(data.id);
                formSelector.find("input[name=name]").val(data.name);
                formSelector.find("input[name=email]").val(data.email);
                formSelector.find("select[name=role]>option[value="+ data.role +"]").prop("selected", true);

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

            },
            error: function (data) {

                location.reload();
            }
        });

        // change form action
        formSelector.prop("action", baseURL + controllerName + "/edit");

    }

</script>