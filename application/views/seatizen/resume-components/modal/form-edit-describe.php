<?php 
	$profile = $resume["profile"]; 
	$pelaut  = $resume["pelaut"];
	
	
?>

<script>

	function update_describe_process()
	{

		var formData = $("#form-describe form").serialize();

		var describe = $("#describe").val();

		

		$.ajax({

			

			type	 : "POST",

			url 	  : "<?php echo base_url("seatizen/update_describe_process"); ?>",

			data	 : formData,

			dataType : "JSON",

			success  : function(data){

				

				$("#info").html(data.message);



			}

			

		});

	}

</script>

<div class="modal fade modal-form-update-describe modal-resume" id="" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

  <div class="modal-dialog modal-lg"><!-- large -->

    <div class="modal-content"> 

    	<div class="modal-header bg-primary" style="padding:-20px 0 -20px 0">

        	<h4>Edit Profile <!-- Certificate of describe --> <button type="button" id="close-modal-btn" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></h4>

        </div>

         

    	<div class="modal-body">

        	

            <div id="info">

            

            </div>

            <div id="form-describe">

            	<form role="form" class="" method="post">
					<?php
						
						
						$rank  	   = $this->rank_model->get_rank_detail_byid($profile["rank"]);
						
						$total_rank = $this->experience_model->total_exp_rank($profile["pelaut_id"]);
						
						$vessel_type = $this->vessel_model->get_shiptype_byshipid($profile["vessel_type"]);
						
						$total_ship = $this->experience_model->total_experience_ship($profile["pelaut_id"],$profile["vessel_type"]);
					
						$str_default = "Describe yourselves. example : I have work as $rank[rank] for $total_rank. Recently I start working on $vessel_type[ship_type] for $total_ship. I am a hardworker and capable to work in any circumstances. Please check my recommendation about me from my colleague seafarers on ".base_url("profile/$pelaut[username]/recommendation").".";
					
					?>
                    <div class="form-group">
                    	<input type="hidden" name="pelaut_id" value="<?=$profile["pelaut_id"]?>" >
                        <textarea class="form-control" name="describe" id="describe" rows="10" style="" placeholder="<?=$str_default?>" ><?php echo $profile['describe'] ?></textarea>
                    </div>

                    <button class="btn btn-warning pull-left" onclick="call_report_form()" type="button" data-loading-text="Loading..."> &nbsp; 

                        <b> Report Problem </b></button>
                        	<button class="btn btn-danger pull-right" data-dismiss="modal"> <span class="glyphicon glyphicon-remove-circle"></span>&nbsp; 
                        <b> Cancel </b> </button>

                        <span class="pull-right">&nbsp;</span>

                        <button class="btn btn-success pull-right" id="describe-update-btn" type="button" data-loading-text="Loading..." onClick="update_describe_process()"> 

                            <span class="glyphicon glyphicon-floppy-disk"></span>&nbsp; <b> Save </b>

                        </button>
                        <span class="clearfix"></span>
            	</form> 

            </div>

        



        </div><!-- modal-body-->

    </div><!-- modal-content -->

  </div><!-- modal-dialog -->

</div><!-- modal -->



<script type="text/javascript">

	

	$(document).ready(function(e) {

		$(".modal-form-update-describe").modal({

			backdrop:"static",

			show:true	

		});

	});

	

// Since confModal is essentially a nested modal it's enforceFocus method

// must be no-op'd or the following error results 

// "Uncaught RangeError: Maximum call stack size exceeded"

// But then when the nested modal is hidden we reset modal.enforceFocus

var enforceModalFocusFn = $.fn.modal.Constructor.prototype.enforceFocus;

$.fn.modal.Constructor.prototype.enforceFocus = function() {};


$confModal.on('hidden', function() {

    $.fn.modal.Constructor.prototype.enforceFocus = enforceModalFocusFn;

});

$confModal.modal({ backdrop : false });

</script>

