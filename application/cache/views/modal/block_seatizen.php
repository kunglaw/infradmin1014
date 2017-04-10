<?php
    if($data_seatizen['activation'] == "ACTIVE") $command = "block";
    else if($data_seatizen['activation'] == "BLOCKED") $command = "unblock";
?>

<div class="modal fade" id="block-seatizen-confirmation" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <?php echo ucfirst($command) ?> Confirmation
            </div>

            <div class="modal-body">
                Are you sure you want to <?php echo $command ?> <?php echo $data_seatizen['nama_depan']." ".$data_seatizen['nama_belakang']; ?> ?
            </div>

            <div class="modal-footer">
                <button type="button" class="button-green-white"
                        id="block-button" onclick="blocked_seatizen(<?php echo $data_seatizen['pelaut_id'] ?>)" data-dismiss="modal"><?php echo ucfirst($command) ?></button>

                <button type="button" class="button-green-white"
                        data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $('#block-seatizen-confirmation').modal({
        show:true,
        backdrop:"static"
    });

function blocked_seatizen (argument) {
    // body...
    // alert(argument);
    $.ajax({
        type:"POST",
        data: "id_seatizen="+argument,
        url: "<?php echo base_url("seatizen/block_seatizen"); ?>",
        success:function (data) {
            // body...

            // window.location = baseURL+"seatizen";
            // if (typeof oTable == "undefined") {
            //     window.location.href = baseURL + route;
            // } else {
            //     oTable.draw();
            // }

            // var notifType = "danger";
            //     if (data.status == "success") {
            //         notifType = data.status;
            //     }

            //     showNotification(notifType, data.notification);
        }
    });
}
// $("#block-seatizen-confirmation").show("modal");
// $(document).ready(function (e) {
//     alert("test dokumen modal ready");
    
//     // $("#block-seatizen-confirmation #block-button").click(function () {
//     //     var data = "id_seatizen=<?=$data_seatizen['pelaut_id']?>";

//     //     // ajax call to delete user
//     //     $.ajax({
//     //         // dataType: "json",
//     //         type: "POST",
//     //         data: data,
//     //         url: <?php echo base_url("seatizen/block_seatizen"); ?>,
//     //         success: function (data) {

//     //             // redraw datatable
//     //             // if (typeof oTable == "undefined") {
//     //             //     window.location.href = baseURL + route;
//     //             // } else {
//     //             //     oTable.draw();
//     //             // }

//     //             // var notifType = "danger";
//     //             // if (data.status == "success") {
//     //             //     notifType = data.status;
//     //             // }

//     //             // showNotification(notifType, data.notification);
//     //         }
//     //     });
//     // });

// });
</script>