/**
 * Created by pulung on 2/12/15.
 */

var listCheckboxes = {};

$(document).ready(function () {

    // get all checkboxes, in all pagination.
    // save every movement on checkbox.
    $("#dataTables-list").on("click", "input[name=list_checkboxes\\[\\]]", function() {

        var checkboxValue = parseInt($(this).val());
        if ($(this).is(":checked")) {
            listCheckboxes[checkboxValue] = checkboxValue;
        } else {
            delete listCheckboxes[checkboxValue];
        }
    });

    $("#dataTables-list [name='id_all']").change(function() {

        var value = false;
        if($(this).is(":checked")) {
            value = true;
        }

        $("#dataTables-list [name='list_checkboxes\\[\\]']").each(function(){
            $(this).prop("checked", value);

            var checkboxValue = parseInt($(this).val());
            if ($(this).is(":checked")) {
                listCheckboxes[checkboxValue] = checkboxValue;
            } else {
                delete listCheckboxes[checkboxValue];
            }
        });
    });
});