<?php //email-agentsea-list ?>
<!-- 
bg-primary : #337AB7
bg-success: #DFF0D8
bg-info   : #D9EDF7
bg-warning : #FCF8E3
bg-danger: #F2DEDE
-->

<div style="
margin:0 auto; 
padding:0; 
font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;
width:80%;
font-size:14px; 
border:1px solid black; ">
	
    <?php include ("header_email_template.php") ?>
    
    <div style="min-height:200px;
    padding:10px 20px 10px 20px;
    ">
    	<!-- body -->
        <!-- <center> 
        	<h2 style="font-size:36px; color:#337AB7"> Hello Seatizen !</h2>
        	<h4 style="font-size:24px; color:#337AB7; margin-top:-30px;"> Find your preferable vacantsea and networking with seafarers or agentsea. </h4> 
        </center> -->
        
        <br>
        <br>
        <br>
        <div style="line-height:20px; font-size:16px;"> 
        	<p><b style="font-size:18px; color:#337AB7;" > Yth <?=$name?> </b></p>
            <br>
            <p> di Tempat </p>
            <p>Semoga email ini menemui <?php echo $name ?> dalam keadaan sehat. Aamiin</p>
            <br>
            <p>Kami dari tim informasea.com berharap dapat membantu para pelaut untuk menemukan pekerjaan dan juga memfasilitasi manning agent untuk menemukan kandidat crew yang tepat dan kompeten.</p>
            <br>
            <p>Berdasarkan pantauan saya di gotoseajobs.com terkait kebutuhan crew <?php echo $company_name ?>, saya ingin menawarkan kerjasama antara informasea.com  dengan <?php echo $company_name ?></p>
            <br>
            <p>Mengingat bahwa <?php echo $company_name ?> sendiri telah memiliki akun di informasea.com, maka penawaran minimal yang dapat kami ajukan sebagai berikut :</p>
            <br>
            <ol>
                <li>informasea.com membantu <?php echo $company_name ?> dengan cara mem-posting lowongan di informasea.com atas nama <?php echo $company_name ?>.</li>
                <li>Lowongan yang di-posting di informasea.com hanya lowongan yang telah <?php echo $company_name ?> buat di gotoseajobs ataupun job portal crewing lainnya.</li>
                <li>informasea.com akan melakukan marketing untuk lowongan tersebut melalui social media yang ada (facebook, twitter, linkedin, g+)</li>
                <li><?php echo $company_name ?> dapat memantau applicant yang telah melamar lowongan tersebut dengan mengakses informasea.com ataupun melalui email.</li>
                <li><?php echo $company_name ?> dapat langsung melihat CV dan resume pelamar melalui informasea.com dan dapat dengan mudah melakukan validasi sertifikat.</li>
                <li>Penawaran ini tidak dipungut biaya demi meningkatkan kebermanfaatan informasea.com sebagai komunitas pelaut dan job portal</li>
            </ol>
            <!-- <p> <b><a href="<?=infr_url()?>"> Informasea </a> </b> helps you :  </p> -->
            <br>
            <br>
            <p>Kami yakin dapat memberikan <?php echo $company_name ?> lebih banyak pilihan dalam proses hiring crew sehingga <?php echo $company_name ?> memiliki peluang yang lebih besar untuk menemukan crew yang kompeten.</p>
            <br>
            <p>Silahkan klik <b>View Contract</b> untuk melihat kontrak yang kami sediakan atau klik <b>Negotiate</b> untuk mengubah/menambah klausul di dalam kontrak.</p>
            <br>
            <p>Saya harap dapat mendengar respon baik dari <?php echo $name ?> atau <a href="<?php echo INFR_URL."contact" ?>">hubungi kami</a> untuk diskusi lebih lanjut.</p>
            <br>
            <br>
            <br>
            <!-- <span style="text-align:right"> -->
                <p>Salam Sukses</p>
                <br>
                <br>
                <br>
                <br>
                <p>Rifal Qori Kurniawan</p>
                <p>Founder Informasea.com</p>
            <!-- </span> -->
            <!-- <ul style="line-height:20px; list-style-type:lower-alpha; ">
            	<li> 
                	<div><b style="color:#337AB7; font-size:18px;"> Find preferable job </b> </div> 
                    
                    <div> Apply any vacantsea based on your qualification. </div>
                    <div> After apply, you can monitor your status, got accepted or rejected. </div> 
                    <div>&nbsp;</div>
                </li>
                <li> 
                	<div><b style="color:#337AB7; font-size:18px;"> Impressive Resume </b></div> 
                    
                    <div> Keep your resume up to date! </div>
                    <div> Agentsea will be able to view your complete resume after applying the vacantsea. </div> 
                    <div> upload all your scan certified and apprisal / performance report. </div>
                    <div> only agentsea with applied vacantsea can view your complete resume. </div>
                    <div>&nbsp;</div>
                </li>
                <li> 
                	<div><b style="color:#337AB7; font-size:18px;"> Networking with other seatizen or agentsea  </b></div> 
                    
                    <div> chat and get connected with all your colleague. </div>
                    <div> Agentsea will be able to view your complete resume after applying the vacantsea. </div> 
                    <div> Chat with any preferable agentsea. </div>
                   
                    <div>&nbsp;</div>
                </li>
                
            </ul> -->
        
        </div>
        <br>
        <br>
        <br>
        <center>
        <?php if(isset($id_contract)) $tambahan = "$id_contract/$token"; else $tambahan = ""; ?>
        <a href="<?php echo INFR_URL."contract/negotiate/$tambahan" ?>" style="font-size: 13pt; color: #ffffff; width: 50%; background-color: #3399ff; padding: 15px 40px 15px 40px; text-decoration : none">Negotiate</a>
        <a href="<?php echo INFR_URL."contract/agree/$tambahan" ?>" style="font-size: 13pt; color: #000000; width: 50%; background-color: #66ff66; padding: 15px 40px 15px 40px; text-decoration : none">View Contract</a>
        </center>
        <br>
        <br>
        <br>
        <!-- <center>
        	<?php //include "list-template-agentsea.php";?>
        </center> -->
        
        <?php include ("email_info.php") ?>
        
    
    </div>
    <?php include "footer_email_template.php" ?>
	
</div>