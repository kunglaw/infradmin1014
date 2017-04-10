<div class="modal fade " id="form_edit_agentsea_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

  <div class="modal-dialog">

    <div class="modal-content">

    

      <form method="post" action="" role="form" id="form-role" >

        <div class="modal-header bg-header-modal">

          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

          

          <h4 class="modal-title"><?=$agentsea['nama_perusahaan']?></h4>

          

        </div>

        <div class="modal-body">

          <?php //print_r($agentsea); ?>

          

          <data></data>

          

          <input value="<?=$agentsea['id_perusahaan']?>" name="id_perusahaan" id="id_perusahaan" type="hidden">

          <div class="col-md-5">

           <h4> Tampil </h4>

            <div class="form-group">

              <select name="tampil" id="role" class="form-control" style="width:90%">

              	<?php

				if($agentsea['tampil'] == "1")

				{

					$selected_manager = "selected=selected";	

				}

				else

				{

					$selected_agent = "selected=selected";	

				}

				?>

              	<option value="1" <?=@$selected_manager?> >Tampil</option>

                <option value="0" <?=@$selected_agent?> >Tidak</option>

              </select>

            </div>

            

            <div class="temp-manager">

            

            </div>

            

          </div>

          <div class="clearfix"></div>         

        </div>

        <div class="modal-footer">

          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

          <button type="button" class="btn btn-primary" id="savea-change">Save changes</button>

        </div>

      </form>

      

    </div><!-- /.modal-content -->

  </div><!-- /.modal-dialog -->

</div><!-- /.modal -->



<script>





function submit_tampil()

{

	$.ajax({

		type:"POST",

		data:$("#form-role").serialize(),

		url:"<?=base_url("agentsea/proses_edit_tampil")?>",

		error:function(dt)

		{

			alert(dt.responseText);	

		},

		success: function(dt){

			

			//alert(dt);

			$("data").html(dt);

			

		}

		

	});	

	

}



function clear_manager()

{

	$(".temp-manager").html("");	

}





$(document).ready(function(e) {

    $('#form_edit_agentsea_modal').modal({

	  show:true,

	  backdrop:"static"

	});

	

	$("#savea-change").click(function(){

		

		submit_tampil();

				

	});

		

	/* $("form #ext_num").msDropDown();

	$("form #nationality").msDropDown();

	$("form #nama_perusahaan_select").msDropDown();*/

});





</script>