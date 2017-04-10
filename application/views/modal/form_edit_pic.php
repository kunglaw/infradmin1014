aaa
<div class="modal fade " id="form_edit_pic" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    
      <form method="post" action="" role="form" id="form-role" >
        <div class="modal-header bg-header-modal">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          
          <h4 class="modal-title"> Change PIC </h4>
          
        </div>

        <div class="modal-body">
        
        	<data> </data>

          <input value="<?=$report['id_report']?>" name="id_report" type="hidden">
          <div class="row">
          <div class="col-md-12">
            <div class="form-group">
            	<?=$report['id_report'];?>
            		<label> PIC </label> &nbsp; &nbsp;
            		<?php echo $report['pic']; ?>
            	<select class="form-group" style="width:60%;" name="pic">
            		<?php $this->load->model('report_model');
          					$all_pic = $this->report_model->get_all_pic();
          	  			foreach($all_pic as $row){ 	 
          	  				if($row['name'] == $report['pic']){
          	  					$selected = "selected='selected'";
          	  					$style = "style='font-weight:bold'";
          	  					$h = "<strong>".$row['name']."</strong>";


          	  				} else
							{
								$selected = "";	
								$style = "";
								$h = $row['name'];
							}

          	  				?>

          	  			 <option value="<?=$row['name'];?>" <?=$selected;?> <?=$style;?>>  <?=$h;?> </option>


            			<?php  } ?>

            	</select>
            	<br><br>
            </div>
            
            
          </div>
          <div class="col-md-4">

          </div>
      </div>

          
        </div>
        <div class="modal-footer">

          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="save-change">Propose </button>
        </div>
      </form>
      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>

function submit_pic()
{
	$.ajax({
		type:"POST",
		data:$("#form-role").serialize(),
		url:"<?=base_url("report_problem/proses_edit_pic")?>",
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

$(document).ready(function(e) {
    $('#form_edit_pic').modal({
	  show:true,
	  backdrop:"static"
	});

	
	$("#save-change").click(function(){
		
		submit_pic();
				
	});
		
	/* $("form #ext_num").msDropDown();
	$("form #nationality").msDropDown();
	$("form #nama_perusahaan_select").msDropDown();*/
});


</script>