<?php // form add seatizen ?>

<script>
	 function getAllRankList(id_department){
		 
            $.ajax({
                url:"<?php echo base_url("seatizen/list_rank"); ?>",
                type:"POST",
                data:datanya,
                success:function(hasil){
                    $("#get_rank_vacant").html(hasil);
                }
            });
    }
    
    function getAllCocList(id_department){
        $.ajax({
            url:"<?php echo base_url("seatizen/list_coc"); ?>",
            type:"POST",
            data:datanya,
            success:function(hasil){
                $("#get_coc_class").html(hasil);
            }
        });
    }
	
	function get_rank(department_id)
	{
		$.ajax({
			
			type:"POST",
			url:"<?php echo base_url("seatizen/get_rank"); ?>",
			data:"department_id="+department_id,
			success: function(data)
			{
				$("#rank").html(data);
			}
			
		});
	}
	
	
</script>

<div class="modal fade" id="form_seatizen_add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    
      <form method="post" action="<?=base_url("seatizen/seatizen_add_process")?>" role="form" id="formid" >
        <div class="modal-header bg-header-modal">
          <button type="button" class="close" onClick="location.reload()" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          
          <h4 class="modal-title"> Form Add Seatizen </h4>
          
        </div>
        <div class="modal-body">
            
            <div class="fsa_info"></div>
            
        	<div class="form-group">
            	<label for=""> Name </label>
                <span class="clearfix">
                <input type="text" class="form-control pull-left" style="width:30%; margin-right:5%" name="first_name" id="first_name" placeholder="fisrtname">
               
                <input type="text" class="form-control" style="width:30%" name="last_name" id="last_name" placeholder="lastname">
                </span>
            </div>
            
            <div class="form-group">
            	<label> Email </label>
                <input type="email" name="email" class="form-control" placeholder="email" style="width:80%" id="email">
            </div>
            
			<div class="form-group" style="width:80%">
                    <label for="department">
                        Department                    	
                    </label>
                    <select class="form-control" name="department" id="department">
                    <?php
                        
                        foreach($department as $row){
                            
                            $sd  = "";
                            if($profile['department'] == $row['department_id'])
                            {
                                $sd = "selected='selected'";
                            }
                    ?>
                        <option value="<?php echo $row['department_id']; ?>" <?php echo $sd ?>><?php echo $row['department']; ?></option>
                    <?php
                        }
                    ?>
                    </select>
                    <script>
                      $("#department").change(function(e)
                      { 
                          var department_id = $(this).val(); 
                          get_coc_class(department_id);
						  get_rank(department_id);
                          
                      });
                      
                     
					 function get_coc_class(department_id)
					  {
                          $.ajax({
                              
                              type:"POST",
                              url:"<?php echo base_url("seatizen/get_coc_class"); ?>",
                              data:"department_id="+department_id,
                              success: function(data)
                              {
                                  $("#coc_class").html(data);
                              }
                              
                          });
                      }
                      
                    </script>
                  </div>
                  
            <div class="form-group" style="width:80%">
              <label for="coc_class">
                  COC Class                    	
              </label>
              <select class="form-control" name="coc_class" id="coc_class">
              <?php
                  
                  foreach($coc_class as $row)
				  {
                    
              ?>
                    
                  <option value="<?php echo $row['id_coc_class']; ?>" ><?php echo $row['coc_class']; ?></option>
              <?php
                    
                  }
              ?>
              </select>
              <script>
                
                
              
              </script>
            </div>
                  
            <div class="form-group" style="width:80%">
              <label for="rank">
                 Rank                 	
              </label>
              <select class="form-control" name="rank" id="rank">
              <?php
                 
                  foreach($rank as $row)
				  {
                      
              ?>
                  <option value="<?php echo $row['rank_id']; ?>" <?php echo $sr ?>><?php echo $row['rank']; ?></option>
              <?php
                  }
              ?>
              </select>
               <script>
                
                
              </script>
            </div>            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" onClick="location.reload()">Close</button>
          <button type="submit" class="btn btn-success" id="save-change">Save changes</button>
        </div>
      </form>
      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

<script>
	function add_seatizen()
	{
		$.ajax({
			type:"POST",
			url:$("#formid").attr("action"),
			data:$("#formid").serialize(),
			dataType:"json",
			success:function(res){
				
				if(res.status == "success")
				{
					$("form #first_name").val("");
					$("form #last_name").val("");
					$("form #email").val("");		
				}
				
				//alert(res.notification);
				//alert(res.response.notification);
				$(".fsa_info").html(res.message);
			}
			
		});
	}
	
	
	$(document).ready(function(e) {
       
	    $('#form_seatizen_add').modal({
		  show:true,
		  backdrop:"static"
		}); 
		
		var department_id = $("#department").val(); 
		get_coc_class(department_id);
        get_rank(department_id); 
		
		$("#form_seatizen_add").submit(function(){
			
			add_seatizen();
			return false;
		});
		
    });
	
</script>