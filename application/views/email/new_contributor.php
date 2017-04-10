<?php $this->load->view("email/header"); ?>

    <div>
        You received this email because you have been registered as <?php echo APPLICATION_NAME; ?> Contributor. <br/><br/>

        Your password: <?php echo $plain_password; ?><br/>
        Please login by visiting <?php echo anchor(base_url() ."contributor/user/sign_in", APPLICATION_NAME ." Contributor"); ?><br/><br/>

    </div>

<?php $this->load->view("email/footer"); ?>