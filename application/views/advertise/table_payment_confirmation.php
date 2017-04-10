<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover" id="dataTables-list">
        <thead class="button-green-white">
        <tr>
            <th style="text-align: center;"> No </th>
            <th>Ad Name</th>
            <th>Bank Account / an</th>
            <th>Purpose Bank</th>
            <th>Total</th>
            <!-- <th>Attachment</th> -->
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php 
             $no=1;
            foreach ($dt_ad_req as $dt) {
                
               // $q = "select title from admin_ad_area where id_area = '$dt[id_area]'";
               // $exec = $this->db->query($q);
               // $data_ad = $exec->row_array();
               // $exec->free_result();

               $q = "select ad_name from admin_advertise_list where id_ad = '$dt[id_ad]'";
               $exec = $this->db->query($q);
               $data_adv = $exec->row_array();
               $exec->free_result();

               // $q = "select amount_periode, range_periode from admin_ad_periode where id_periode = '$dt[id_periode]'";
               // $exec = $this->db->query($q);
               // $data_periode = $exec->row_array();
               // $exec->free_result();

               // $ad_periode = ($dt['quantity_periode']*$data_periode['amount_periode']);
        ?>
            <tr <?=$class ?>>
              <td class="center reference" >
                    
                    <span data-toggle="popover" data-content="<?=$data_content?>" 
                    title="<?=$title_popup?>" class="ipop">
                       # <?=$dt["id_ad"]?>
                    </span>
              </td>
              <td class="left name" >
                <div data-toggle="popover" class="ipop pull-left" data-content="<?=$data_content?>" 
                title="<?=$title_popup?>"> 
                    <?=$data_adv['ad_name']?>                                          
                </div>
              </td>
              <td class="left linkable" >
                <div data-toggle="popover" class="ipop" data-content="<?=$data_content?>"
                title="<?=$title_popup?>"> 
                    <?="$dt[bank_account] / $dt[bank_account_an]"?>
                </div>
              </td>
              <td class="left linkable" >
                <div data-toggle="popover" class="ipop" data-content="<?=$data_content?>"
                title="<?=$title_popup?>"> 
                    <?="$dt[purpose_bank]"?> 
                </div>
              </td>
              <!-- <td>
                  <a href="<?=infr_url("infrasset/advertise/$dt[media]")?>" target="_blank"><?=$dt["media"]?></a>
                  
              </td> -->
              <td>
                <?php echo number_format($dt['total']) ?>
              </td>
              
              <td>
                
                 
                  
                 
                  
                  
              
              </td>
             
              
          </tr>
                <?php
                
            }
            
         ?>
        </tbody>
    </table>
</div>