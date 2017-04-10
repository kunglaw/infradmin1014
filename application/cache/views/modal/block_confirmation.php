

<div class="modal fade" id="block-many-confirmation" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                Block Confirmation
            </div>

            <div class="modal-body">
                Are you sure you want to block this row?
            </div>

            <div class="modal-footer">
                <button type="button" class="button-green-white "
                        id="block-button" data-dismiss="modal">Block</button>

                <button type="button" class="button-green-white "
                        data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="block-one-confirmation" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                Block Confirmation
            </div>

            <div class="modal-body">
                Are you sure you want to block this row?
            </div>

            <div class="modal-footer">

                <input type="hidden" name="object-id" />

                <button type="button" class="button-green-white "
                        id="block-button" data-dismiss="modal">Block</button>

                <button type="button" class="button-green-white "
                        data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function () {

    var route = '<?php echo $route; ?>';

    // fill object ID target to be blockd individually.
    $("#dataTables-list").on("click", ".block-one-button", function () {

        var objectID = $(this).next().val();
        $("#block-one-confirmation #block-button").prev().val(objectID);
    });

    // fill object ID target to be blockd individually.
    $(".block-one-button").click(function () {

        var objectID = $(this).next().val();
        $("#block-one-confirmation #block-button").prev().val(objectID);
    });

    $("#block-many-confirmation #block-button").click(function () {

        var data = {listCheckboxes: JSON.stringify(listCheckboxes)};
        data[bulkActionCSRFToken] = bulkActionCSRFValue;

        // ajax call to delete user
        $.ajax({
            dataType: "json",
            type: "POST",
            data: data,
            url: baseURL + route + "/block/several",
            success: function (data) {

                // redraw datatable
                if (typeof oTable == "undefined") {
                    window.location.href = baseURL + route;
                } else {
                    oTable.draw();
                }

                var notifType = "danger";
                if (data.status == "success") {
                    notifType = data.status;
                }

                showNotification(notifType, data.notification);
            }
        });
    });

    $("#block-one-confirmation #block-button").click(function () {

        var objectID = $(this).prev().val();
        var data = {id: objectID};
        data[bulkActionCSRFToken] = bulkActionCSRFValue;

        // ajax call to delete user
        $.ajax({
            dataType: "json",
            type: "POST",
            data: data,
            url: baseURL + route + "/block/one",
            success: function (data) {

                // redraw datatable
                if (typeof oTable == "undefined") {
                    window.location.href = baseURL + route;
                } else {
                    oTable.draw();
                }



                var notifType = "danger";
                if (data.status == "success") {
                    notifType = data.status;
                }

                showNotification(notifType, data.notification);
            }
        });
    });
});
</script>