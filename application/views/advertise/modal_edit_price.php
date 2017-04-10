<div class="modal fade" id="activate-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    	
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"> Activate Ad </h4>
        </div>
        
        <form role="form" id="activate-modal-form">
          <div class="modal-body">
          	<div class="info-activate-modal"></div>
          
          	<input type="hidden" name="id_area" id="id_ad" value="<?=$detail_area["id_area"]?>">
          	
            <div class="form-group">
            	<label> Title </label>
                <input class="form-control" type="text" name="ad_title" id="ad_title" value="<?=$detail_area["title"]?>">
            </div>
            <div class="form-group">
              <label> Size </label>
                <input class="form-control" type="text" name="ad_size" id="ad_size" value="<?=$detail_area["size"]?>">
            </div>

            <div class="form-group">
              <label> Currency </label>
              <?php //echo trim($detail_area['currency']) ?>
              &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="ad_currency" value="IDR" <?php echo trim($detail_area['currency']) == "IDR" ? "checked" : "" ?>> IDR&nbsp;
                <input type="radio" name="ad_currency" value="USD" <?php echo trim($detail_area['currency']) == "USD" ? "checked" : "" ?>> USD

            </div>

            <div class="form-group">
              <label> Price </label>
                <input class="form-control" type="text" name="ad_price" id="ad_price" value="<?=$detail_area["price"]?>">
            </div>
            
            <div class="form-group">
             <label>Active</label>
             <select name="status" id="status" class="form-control">
             	<option value="off" <?php echo $detail_area['active'] == "FALSE" ? "selected" : "" ?>> Off </option>
                <option value="on" <?php echo $detail_area['active'] == "TRUE" ? "selected" : "" ?>> On </option>
             </select>
            </div>
             
          </div>
          
          <div class="modal-footer">
            <button type="button" class="btn btn-default" id="btn-dismiss" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="Activate">Save changes</button>
          </div>
        </form>
        
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function () {
    $("#activate-modal").modal({
      show: true,
      backdrop: 'static'
    })

    $("#Activate").click(function () {
      var dt = "x=1&"+$("#activate-modal-form").serialize();
      $.ajax({
        data: dt,
        type: "POST",
        url : "<?php echo base_url() ?>advertise/process_edit_area",
        success: function (out) {
          location.reload();
        }
      })
    })
  })


</script>