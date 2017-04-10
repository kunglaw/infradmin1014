<?php $this->load->view("email/header"); ?>

<div>
You received this email because you request to reset your password. <br/><br/>

Please reset your password by visiting this link below.<br/>
<?php echo $recovery_link; ?> <br/><br/>

</div>

<?php $this->load->view("email/footer"); ?>