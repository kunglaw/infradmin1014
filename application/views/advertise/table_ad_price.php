<div class="table-responsive">
      
      <table class="table table-striped table-bordered table-hover" id="dataTables-list">
          <thead class="button-green-white">
          <tr>
              <th style="text-align: center;"> No </th>
              <th>Title</th>
              <th>Size</th>
              <th>Price</th>
              <th>Status</th>
              <!-- <th>Attachment</th> -->
              <th>Action</th>
          </tr>
          </thead>
          <tbody>
          <?php 
               $no = 1;
             // echo "list price aktif";
              foreach ($dt_ad_req as $dt) {
                  // <div> PIC : ".$dt['pic']." </div>".                                                "<div> on: ".$dt['datetime']." </div> 
                  $data_content = "";
                  $title_popup = "Note:";
          ?>
              <tr <?=$class ?>>
                <td class="center reference" >
                      
                      <input type="checkbox" id="delete-email" value="<?=$dt['id_area']?>" name="se[]" class="del-sm">
                      
                      <span data-toggle="popover" data-content="<?=$data_content?>" 
                      title="<?=$title_popup?>" class="ipop">
                          <?=$no++?>
                      </span>
                </td>
                <td class="left name" >
                  <div data-toggle="popover" class="ipop pull-left" data-content="<?=$data_content?>" 
                  title="<?=$title_popup?>"> 
                      <?=$dt['title']?>                                          
                  </div>
                </td>
                <td class="left linkable" >
                  <div data-toggle="popover" class="ipop" data-content="<?=$data_content?>"
                  title="<?=$title_popup?>"> 
                      <?=$dt['size']?>
                  </div>
                </td>
                <td class="left linkable" >
                  <div data-toggle="popover" class="ipop" data-content="<?=$data_content?>"
                  title="<?=$title_popup?>"> 
                      <?="$dt[currency] ".number_format($dt['price'])?> 
                  </div>
                </td>
                <td class="left linkable" >
                  <div data-toggle="popover" class="ipop" data-content="<?=$data_content?>"
                  title="<?=$title_popup?>"> 
                      <?= $dt['active'] == "TRUE" ? "Active" : "Not Active" ?>
                  </div>
                </td>
                <!-- <td class="left linkable">
                  <div data-toggle="popover" class="ipop" data-content="<?=$data_content;?>"
                      title="<?=$title_popup;?>">
                      <?=$dt['attachment']?> 
                  </div>
                </td> -->
                <td align="center">
                   
                    
                    <a class="btn btn-primary" title="Edit" onClick="show_edit_modal(<?=$dt['id_area']?>, 'list_price')" 
                    href="#">

                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    
                    
                </td>
            </tr>
                  <?php
                  
              }
              
           ?>
          </tbody>
      </table>
  </div>