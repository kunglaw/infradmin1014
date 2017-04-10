
<div class="modal fade" id="reject-request-one-confirmation" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                Reject Request Confirmation
            </div>

            <div class="modal-body">
                Are you sure you want to reject this request?
            </div>

            <div class="modal-footer">

                <input type="hidden" name="object-id" />
                <input type="hidden" name="type" />
                <input type="hidden" name="author-id" />

                <button type="button" class="button-green-white "
                        id="reject-request-button" data-dismiss="modal">Reject</button>

                <button type="button" class="button-green-white "
                        data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
$(document).ready(function () {

    var route = '<?php echo $route; ?>';
    var objectID;
    var type;
    var authorID;

    // fill object ID target to be reject-requestd individually.
    $("#dataTables-list").on("click", ".reject-request-one-button", function () {

        objectID = $(this).parent().find("input.object-id").val();
        type = $(this).parent().find("input.type").val();
        authorID = $(this).parent().find("input.author-id").val();

        $("#reject-request-one-confirmation").find("input[name=object-id]").val(objectID);
        $("#reject-request-one-confirmation").find("input[name=type]").val(type);
        $("#reject-request-one-confirmation").find("input[name=author-id]").val(authorID);
    });

    // fill object ID target to be reject-requestd individually.
    $(".reject-request-one-button").click(function () {

        objectID = $(this).parent().find("input.object-id").val();
        type = $(this).parent().find("input.type").val();
        authorID = $(this).parent().find("input.author-id").val();

        $("#reject-request-one-confirmation").find("input[name=object-id]").val(objectID);
        $("#reject-request-one-confirmation").find("input[name=type]").val(type);
        $("#reject-request-one-confirmation").find("input[name=author-id]").val(authorID);
    });


    $("#reject-request-one-confirmation #reject-request-button").click(function () {

        var data = {id: objectID, type: type, author: authorID};
        data[bulkActionCSRFToken] = bulkActionCSRFValue;

        // ajax call to delete user
        $.ajax({
            dataType: "json",
            type: "POST",
            data: data,
            url: baseURL + route + "/reject",
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