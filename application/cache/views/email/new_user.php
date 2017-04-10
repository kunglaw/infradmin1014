<?php $this->load->view("email/header"); ?>

    <div>
        You received this email because you have been registered as <?php echo APPLICATION_NAME; ?> User. <br/><br/>

        Your password: <?php echo $plain_password; ?><br/>
        Please login by visiting <?php echo anchor(base_url() ."user/sign_in", APPLICATION_NAME); ?><br/><br/>

    </div>

<?php $this->load->view("email/footer"); ?>