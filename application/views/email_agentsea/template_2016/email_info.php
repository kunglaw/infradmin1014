<?php

if($is_info == ""){ $is_info = 1; } // $is_info = 0
if($is_info == 1){ ?>
<br><br><hr>
<div style="color:grey; font-size:smaller">
    <div>Have fun on board.</div>
    <div><b style="color:#337AB7">Informasea</b> team, </div>
    <b><a href="mailto:<?=$config["smtp_user"]?>"  target="_blank"><?=$config["smtp_user"]?></a></b>
    
    <p>This Email was sent to <b><?=$email_to?></b> from 
    <b><a href="mailto:<?=$config["smtp_user"]?>" target="_blank"><?=$config["smtp_user"]?></a></b> 
    in accordance with 
    <a href="<?=infr_url("our-policy")?>" style="text-decoration:none">our policy</a> </p>
    
    <p>* please, do not reply any kind of message to this email </p>
</div>
<?php } ?>