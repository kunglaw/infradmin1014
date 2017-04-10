<?php //introducing agentsea ?>

<center>
    <h1 style="font-size:36px; color:#337AB7"> Hello Agentsea !!! </h1>
    <h2 style="margin-top:-25px; color:#337AB7"> Manage crew's document and hire qualified crew </h2>
    
    <?php if(!empty($file_img) && $file_img != "%3c" && $file_img != "<"): ?>
        <br>
    <img src="<?=EMAIL_IMG.$file_img?>" style="width:100%; max-width: 256px">
    <input type="hidden" name="file_imgnya" value="<?php echo $file_img ?>">
    <br>
    <?php endif; ?>
    
</center>

<div>
    <h3> dear, Mr/s. <?=$contact_person?>  </h3>
    
    <p> Introducing our service to make all your works easier. </p>
    
    <p> <b>Informasea</b> help you : </p>
    
    <ul style="list-style-type:lower-alpha">
        <li>
            <p>
            <div> <b> to manage your crew's document. </b></div>
            <div> no more worries about expired document. </div>
            <div> our alert system will inform you 6 months before expired date. </div>
            </p>
        
        </li>
        <li>	
            <p>
            <div> <b> Post and share vacantsea. </b> </div>
            <div> looking for crew ? </div>
            <div> you can search your crew candidate based on department / rank / experience. </div>
            <div> After Publish your vacantsea, seatizen will apply and you can check their CV, document and also appraisal. </div>
            <div> choose your qualified applicant and hired them. </div>
            <div> Create your crew's ship assignment immediately. </div>
            </p>
        </li>
        <li>
            <p>
                <div> <b> do you have agents to help your work ? </b> </div>
                <div> no worries! </div>
                <div> Our System allowed any colleagues working on the same company dashboard. </div> 
                <div> as manager you can delegate agent to handle some vessels and crew's ship assignment. </div>
                
            <p>
        </li>
    
    </ul>
    
    <p> 
        <h4> Need More ? <br>
         Click button below and speed up your works. </h4> 
    </p>
    
    <?=""// $content?>

</div>