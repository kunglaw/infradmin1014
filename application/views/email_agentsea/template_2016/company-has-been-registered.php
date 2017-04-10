

    <div>
    	<!-- body -->
        <center> <h3>Company has been registered </h3> </center>
		
        <div style="line-height:20px">
        	<p>Dear Mr/Mrs <?=$contact_person?></p>
            <p>We are truly sorry for this inconvinience.we couldn't send your activation code because 
            
            this company has beeen registered by <?=$another_contact_person?>
            </p>

            <p>If you are an agent from this company, please kindly ask the manager to add yourself as an agent from your company dashboard web</p> 
            
            <p>Please kindly contact us if you have any question</p>
        </div>
        
        <!-- info -->
        <div>
        	<div>Best Regard , </div>
            <div><b style="color:#337AB7">Informasea</b> team, </div>
            <b><a href="mailto:<?=$config["smtp_user"]?>" style="text-decoration:none"><?=$config["smtp_user"]?></a></b>
            
            <p>This Email was sent to <b><?=$email_to?></b> from 
            <b><a href="mailto:<?=$config["smtp_user"]?>" style="text-decoration:none"><?=$config["smtp_user"]?></a></b> 
            in accordance with 
            <a href="<?=infr_url("our-policy")?>" style="text-decoration:none">our policy</a> </p>
            
            <p>* please, do not reply any kind of message to this email </p>
        </div>
        
    
    </div>
