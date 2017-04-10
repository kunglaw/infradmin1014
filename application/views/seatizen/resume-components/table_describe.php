<?php ?>

	

      <h3  class="page-header" style="padding-bottom:0px"> Profile </h3>

      <i> ( Describe yourselves )</i>

    

    <button class="pull-right btn btn-filled btn-sm" id="describe-btn" modal="form-edit-describe">

        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp; Edit

    </button>

    <div class="clearfix"></div>

    <hr />

   	<?php if(!empty($profile["describe"])){

		

		echo "<i class='fa fa-quote-left' aria-hidden='true'></i> &nbsp; ";

		echo "<i style='font-size:16px'>".$profile["describe"]."</i>";

		echo " &nbsp; <i class='fa fa-quote-right' aria-hidden='true'></i>  ";

		

	}else

	{

		echo "<i> Please Describe yourselves </i>";	

	}?>    

    <hr />
