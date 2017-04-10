

<div class="modal fade" id="delete-many-confirmation" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                Delete Confirmation
            </div>

            <div class="modal-body">
                Are you sure you want to delete this row?
            </div>

            <div class="modal-footer">
                <button type="button" class="button-green-white "
                        id="delete-button" data-dismiss="modal">Delete</button>

                <button type="button" class="button-green-white "
                        data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delete-one-confirmation" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                Delete Confirmation
            </div>

            <div class="modal-body">
                Are you sure you want to delete this row?
            </div>

            <div class="modal-footer">

                <input type="hidden" name="object-id" />

                <button type="button" class="button-green-white "
                        id="delete-button" data-dismiss="modal">Delete</button>

                <button type="button" class="button-green-white "
                        data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php
if (! isset($delete_parent_route)) {
    $delete_parent_route = "";
}
?>

<script type="text/javascript">
    $(document).ready(function () {

        var tableName = '<?php echo $table_name; ?>';
        var parentRoute = '<?php echo $delete_parent_route; ?>';

        // fill object ID target to be deleted individually.
        $("#dataTables-list").on("click", ".delete-one-button", function () {

            var objectID = $(this).next().val();
            $("#delete-one-confirmation #delete-button").prev().val(objectID);
        });

        // fill object ID target to be deleted individually.
        $(".delete-one-button").click(function () {

            var objectID = $(this).next().val();
            $("#delete-one-confirmation #delete-button").prev().val(objectID);
        });

        $("#delete-many-confirmation #delete-button").click(function() {

            var data = { listCheckboxes: JSON.stringify(listCheckboxes) };
            data[bulkActionCSRFToken] = bulkActionCSRFValue;

            // ajax call to delete user
            $.ajax({
                dataType: "json",
                type: "POST",
                data: data,
                url: baseURL + "object/delete/several/" + tableName,
                success: function (data) {

                    // redraw datatable

                    if (typeof oTable == "undefined") {
                        window.location.href = baseURL + parentRoute;
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

        $("#delete-one-confirmation #delete-button").click(function() {

            var objectID = $(this).prev().val();
            var data = { id: objectID };
            data[bulkActionCSRFToken] = bulkActionCSRFValue;

            // ajax call to delete user
            $.ajax({
                dataType: "json",
                type: "POST",
                data: data,
                url: baseURL + "object/delete/one/" + tableName,
                success: function (data) {

                    // redraw datatable

                    if (typeof oTable == "undefined") {
                        window.location.href = baseURL + parentRoute;
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