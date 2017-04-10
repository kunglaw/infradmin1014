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



<?php

?>
<div class="row" style="margin-bottom: 5px;">
    <div class="col-md-12">
        Privileges
    </div>
</div>
<div class="row" style="margin-bottom: 10px;">
    <div class="col-md-12">
        <div class="row">
            <?php foreach ($page_list as $id => $page): ?>


                <div class="col-md-4">
                    <?php
                    echo form_checkbox(
                        array(
                            "id" => "checklist". $id,
                            "name" => "privileges[]"
                        ),
                        $id
                    );

                    echo form_label($page, "checklist". $id, array("style" => "display: inline-block;"));
                    ?>
                </div>

            <?php endforeach; ?>
        </div>
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

        // clear all input in create-edit-form
        formSelector.find("input").not("input[type=submit], input[name=token_field], " +
            "input[name=csrf_token], input[name=privileges\\[\\]]").val("");
        formSelector.find("input[name=privileges\\[\\]]").prop("checked", "");
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

        formSelector.find("input[name=name]").val("");
        formSelector.find("input[name=privileges\\[\\]]").prop("checked", "");

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

                for (i = 0; i < data.privileges.length; i++) {
                    formSelector.find("input[id=checklist"+ data.privileges[i] +"]").prop("checked", "checked");
                }

                formSelector.find("input[id]>option[value="+ data.role +"]").prop("selected", true);

            },
            error: function (data) {

                location.reload();
            }
        });

        // change form action
        formSelector.prop("action", baseURL + controllerName + "/edit");

    }

</script>