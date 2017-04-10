<?php $this->load->view("email/header"); ?>

    <div>
        You received this email because you have been registered as Admin <?php echo APPLICATION_NAME; ?>. <br/><br/>

        Your password: <?php echo $plain_password; ?><br/>
        Please login by visiting <?php echo anchor(base_url() ."admin", "Admin ". APPLICATION_NAME); ?><br/><br/>

    </div>

<?php $this->load->view("email/footer"); ?>