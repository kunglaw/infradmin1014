<html>
<head>
 	<!-- Bootstrap Core CSS -->
    <link href="<?php echo bower_url() ."bootstrap/"; ?>dist/css/bootstrap.min.css" rel="stylesheet">
    
     <!-- jQuery -->
    <script src="<?php echo bower_url() ."jquery/"; ?>dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo bower_url() ."bootstrap/"; ?>dist/js/bootstrap.min.js"></script>
    
</head>

<body>
<div class="modal" id="myModal" tabindex="-1" role="dialog">

	
    <?php $this->load->view("email_agentsea/demo-dashboard"); ?>
    

</div><!-- /.modal -->

<script>
$('#myModal').modal({
  keyboard: false,
  show:true
})
	
</script>
</body>

