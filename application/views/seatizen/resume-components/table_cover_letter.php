<?php ?>

	

      <h3  class="page-header" style="padding-bottom:0px"> Cover Letter </h3>

    

    <button class="pull-right btn btn-filled btn-sm" id="cover-letter-btn" modal="form-update-cover-letter">

        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp; Edit

    </button>

    <div class="clearfix"></div>

    <hr />

   	<?php if(!empty($profile["cover_letter"])){
	?>
		

		<?php if(!empty($profile["cover_letter"])){ ?>
			<?=htmlspecialchars_decode(html_entity_decode($profile["cover_letter"]))?>
        <?php } ?>

		
	<?php
	}else

	{

		echo "<i> Please write your Cover Letter </i>";	

	}?>    

    <hr />
