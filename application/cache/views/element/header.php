<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo get_page_title(); ?> | <?php echo APPLICATION_NAME; ?></title>

    <link rel="icon" href="<?php echo base_url();?>assets/img/favicon.png" type="image/png"/>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo bower_url() ."bootstrap/"; ?>dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo plugin_url() ."sb-admin-2/"; ?>css/plugins/metisMenu/metisMenu.min.css"
          rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="<?php echo plugin_url() ."sb-admin-2/"; ?>css/plugins/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo plugin_url() ."sb-admin-2/"; ?>css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="<?php echo bower_url() ."morrisjs/"; ?>morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo bower_url() ."font-awesome/"; ?>css/font-awesome.min.css"
          rel="stylesheet" type="text/css">


    <!-- Magnific Popup CSS -->
    <link href="<?php echo plugin_url() ."magnific-popup/"; ?>magnific-popup.css" rel="stylesheet" type="text/css">


    <!-- User CSS -->
    <?php echo css("general.css"); ?>
    <?php echo css("admin.css"); ?>

    <!-- jQuery -->
    <script src="<?php echo bower_url() ."jquery/"; ?>dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo bower_url() ."bootstrap/"; ?>dist/js/bootstrap.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script>
        var bulkActionCSRFToken = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var bulkActionCSRFValue = '<?php echo $this->security->get_csrf_hash(); ?>';
    </script>

    <script>

        var imageURL = '<?php echo img_url(); ?>';

        /**
         * Show notification above the list, not on the popup.
         * @param type
         * @param message
         */
        function showNotification(type, message) {

            var notification =
                '<div class="alert alert-'+ type +' alert-dismissible">' +
                '<div class="sub-alert-'+ type +'">' +
                message +
                '</div>' +
                '</div>';

            $("#notification-area").html(notification);
        }

        /**
         * Handle image when user image error.
         * @param image
         * @returns {boolean}
         */
        function handleUserImageError(image) {
            image.onerror = "";
            image.src = imageURL + "img_default_profile.png";
            return true;
        }

        /**
         * Check if session has expired.
         */
        var baseURL = '<?php echo base_url(); ?>';
        var lastActivityTime = 0;

        /**
         * Update last activity time.
         */
        function updateLastActivity() {
            lastActivityTime = new Date().getTime() / 1000;
            lastActivityTime = Math.floor(lastActivityTime);
            document.cookie = "last_move=" + lastActivityTime + ";";
        }

        updateLastActivity();

        setInterval(
            function() {

                var currentTime = new Date().getTime() / 1000;
                currentTime = Math.floor(currentTime);

                var cookieData = document.cookie.split(";");
                var cookieKey = "last_move=";

                for (var i = 0; i < cookieData.length; i++) {

                    var cookieValue = cookieData[i];

                    while(cookieValue.charAt(0) == ' ') {
                        cookieValue = cookieValue.substring(1, cookieValue.length);
                    }

                    if (cookieValue.indexOf(cookieKey) == 0) {
                        lastActivityTime = cookieValue.substring(cookieKey.length, cookieValue.length);
                        lastActivityTime = parseInt(lastActivityTime);
                    }
                }

                var inactivitySecond = currentTime - lastActivityTime;

                if (inactivitySecond >= 900) {
                    window.location.href = baseURL + "logout";
                }
            },
            20000
        );

        $(document).ready(function() {

            $(document).mousemove(function() {
                updateLastActivity();
            });

            $(document).click(function() {
                updateLastActivity();
            });

            $(document).keypress(function() {
                updateLastActivity();
            });
        });
    </script>

    <!-- Image cropper style -->
    <?php if (
        NEED_IMAGE_TOOLS_GLOBAL ||
        (isset($need_image_tools) ? $need_image_tools : FALSE)
    ): ?>

        <link rel="stylesheet" type="text/css"
              href="<?php echo bower_url(); ?>cropper/dist/cropper.min.css">
        <link rel="stylesheet" type="text/css"
              href="<?php echo plugin_url(); ?>crop-avatar/css/main.css">

    <?php endif; ?>

</head>

<body>
<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

        <!-- /.navbar-header -->

        <?php $this->load->view("element/navigation_bar"); ?>

        <?php $this->load->view("element/sidebar"); ?>

    </nav>