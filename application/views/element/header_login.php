<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title><?php echo get_page_title(); ?> | <?php echo APPLICATION_NAME; ?></title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="<?php echo base_url();?>assets/img/favicon.png" type="image/png"/>

    <?php echo js("jquery-1.11.2.min.js"); ?>

    <link rel="stylesheet" type="text/css"
          href="<?php echo plugin_url(); ?>bootstrap3/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css"
          href="<?php echo plugin_url(); ?>bootstrap3/css/bootstrap-theme.min.css">

    <script type="text/javascript"
            src="<?php echo plugin_url(); ?>bootstrap3/js/bootstrap.min.js"></script>

    <!-- User CSS -->
    <?php echo css("general.css"); ?>
    <?php echo css("login.css"); ?>
</head>
<body class="login-wrapper">
<div class="container-fluid">

