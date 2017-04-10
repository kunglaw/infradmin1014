<?php
/**
 * Created by PhpStorm.
 * User: pulung
 * Date: 29/10/14
 * Time: 14:20
 */
?>


<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="<?php echo base_url(); ?>">
        <?php
        echo img("logo-white.png",
            array("style" => "height: 100%;"));
        ?>
    </a>
</div>
<!-- /.navbar-header -->


<ul class="nav navbar-top-links navbar-right">
    <li class="dropdown">
        <a class="dropdown-toggle notification-toggle" data-toggle="dropdown" href="#" style="color: white;">
            <i class="fa fa-bell fa-fw"></i>
            <span class="notification-alert" style="display: none;"></span>
        </a>
        <ul class="dropdown-menu dropdown-user dropdown-menu-right notification-status">

            <li class="divider"></li>
            <li class="all-notification" style="text-align: center;">
                <a href="<?php echo base_url(); ?>notification">
                    See all notifications...
                </a>
            </li>
        </ul>
        <!-- /.dropdown-user -->
    </li>
    <!-- /.dropdown -->
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="color: white;">
            Hi, <?php echo $this->session->userdata("name"); ?>&nbsp; <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-user dropdown-menu-right">
            <li>
                <a href="#edit-own-profile-popup" class="edit-own-profile-button">Edit Profile</a>
                <input type="hidden" class="user-id" value="<?php echo $this->session->userdata("id"); ?>" />

                <a href="#edit-own-profile-popup" class="edit-own-profile-button-return-action"
                   style="display: none;"></a>
            </li>
            <li>
                <a href="#change-password-popup" class="change-password-button">Change Password</a>
                <input type="hidden" class="user-id" value="<?php echo $this->session->userdata("id"); ?>" />

                <a href="#change-password-popup" class="change-password-button-return-action"
                   style="display: none;"></a>
            </li>
            <li class="divider"></li>
            <li><a href="<?php echo base_url() ."logout"; ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
            </li>
        </ul>
        <!-- /.dropdown-user -->
    </li>
    <!-- /.dropdown -->
</ul>
<!-- /.navbar-top-links -->

<script type="text/javascript">

    var baseURL = "<?php echo base_url(); ?>";
    var lastTimestamp = 0;
    var totalNewNotification = 0;

    function checkNewNotification() {

        $.ajax({
            dataType: "json",
            type: "POST",
            data: {csrf_token: bulkActionCSRFValue},
            url: baseURL + "notification/get/new/",
            success: function(data) {

                totalNewNotification = data.new_amount;

                $("ul.notification-status > li.notification-element").remove();

                if (data.notifications.length > 0) {

                    for (i = 0; i < data.notifications.length; i++) {

                        var notificationElement = '<li class="notification-element">' + data.notifications[i] + '</li>';
                        $("ul.notification-status").prepend(notificationElement);
                    }

                    if (totalNewNotification > 0) {

                        $("a.notification-toggle > span.notification-alert").html(totalNewNotification);
                        $("a.notification-toggle > span.notification-alert").show();

                    } else {

                        $("a.notification-toggle > span.notification-alert").html("");
                        $("a.notification-toggle > span.notification-alert").hide();
                    }



                } else {

                    var notificationElement = '<li class="notification-element"><a href="#">No new notification</a></li>';
                    $("ul.notification-status").prepend(notificationElement);

                    $("a.notification-toggle > span.notification-alert").html("");
                    $("a.notification-toggle > span.notification-alert").hide();
                }
            }
        });
    }

    checkNewNotification();

    setInterval(checkNewNotification, 20000);


</script>


<!-- Magnific Popup JavaScript -->
<script src="<?php echo plugin_url() . "magnific-popup/"; ?>jquery.magnific-popup.min.js"></script>

<!-- jQuery Form JavaScript -->
<script type="text/javascript" src="<?php echo plugin_url() ."jquery-form/jquery.form.js"; ?>"></script>

<!-- jCrop CSS + JavaScript -->
<link rel="stylesheet" href="<?php echo plugin_url() . "jcrop/css/"; ?>jquery.Jcrop.min.css" />
<script src="<?php echo plugin_url() . "jcrop/js/"; ?>jquery.Jcrop.min.js"></script>

<?php $this->load->view("admin/edit_own_profile_popup"); ?>
<?php $this->load->view("admin/change_password_popup"); ?>



<script type="text/javascript">


    var clickedElement = null; // no-action follow up trigger

    $(document).ready(function() {

        // align the width and height of upload target.
        $(".upload-target").css("line-height", "100px");

        // register triggers for magnific popup
        $(".edit-own-profile-button, .edit-own-profile-button-return-action").magnificPopup({
            closeOnBgClick: false,
            callbacks: {
                close: function() {

                    $(".thumbnail-wrapper").hide();
                    $(".thumbnail-wrapper-footer").hide();

                    $(".thumbnail-view").show();
                }
            }
        });

        // register triggers for magnific popup
        $(".change-password-button, .change-password-button-return-action").magnificPopup({
            closeOnBgClick: false
        });

        $("li.all-notification a").click(function() {

            $.ajax({
                dataType: "json",
                type: "POST",
                data: {csrf_token: bulkActionCSRFValue},
                url: baseURL + "notification/update/time"
            });
        });
    });
</script>