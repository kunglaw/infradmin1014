
<?php

/**
 * Created by PhpStorm.
 * User: pulung
 * Date: 29/10/14
 * Time: 13:00
 */
 
 $total_active = count($this->seatizen->seatizen_active());
 $total_hidden = count($this->seatizen->seatizen_hidden());

 // echo "<pre>";
 // print_r($list_seatizen);
 // echo "</pre>";

?>
<?php $this->load->view("element/header");
    
 ?>
<div class="seatizen-modal-temp"></div>

<form action="<?=base_url("seatizen/import")?>" id="form-upload-seatizen" style="display:none" method="post" enctype="multipart/form-data" >  
	<input type="file" name="excel_file" id="seatizen_dtexcel" />
    <input type="submit" name="submit" id="submit" />
 
</form>

    <!-- DataTables CSS -->
    <link href="<?php echo bower_url("datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css"); ?>" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="<?php echo bower_url("datatables-responsive/css/dataTables.responsive.css"); ?>" rel="stylesheet">
	<div id="modal-block-seatizen"></div>
    <div id="modal-change-activation"></div>
    <script>
    function blockSeatizen (id_seatizen) {
        // body...\
        // alert("im clicked "+id_seatizen);
        $.ajax({
            type:"POST",
            data:"x=1&pelaut_id="+id_seatizen,
            url:"<?=base_url("seatizen/FormBlockSeatizen")?>",
            success:function(data){
                
                $("#modal-block-seatizen").html(data);
            }
        });
    }
	
	function change_activation(id_seatizen)
	{
		$.ajax({
			
			type:"POST",
			data:"pelaut_id="+id_seatizen,
			url:"<?=base_url("seatizen/change_activation")?>",
			success: function(data){
				
				$("#modal-change-activation").html(data);
				
			}
			
		});
			
		
		
	}
    </script>
    
    <div id="page-wrapper">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header">
                    SEATIZEN MANAGEMENT  &nbsp; ( <?=$total_active?> active )                   
                    
                    <span class="pull-right">
                    	
                        <a class="button-green-white" style="margin-right:10px;" onclick="form_seatizen_add()">
                        	<i class="glyphicon glyphicon-plus-sign"></i> 
                            Add Seatizen 
                        </a>
                        
                        <a href="<?=base_url("seatizen/complete")?>" class="button-green-white"
                        style="margin-right: 10px;">
                        	 <i class="fa fa-arrow-circle-down"></i>
                          Seatizen Complete
                        </a>
                        
                        <a href="<?php echo base_url("seatizen/download_excel_template") ?>" class="button-green-white"
                        style="margin-right: 10px;">
						
                          <i class="fa fa-arrow-circle-down"></i>
                          Download Template
                          
                        </a>
    
                        <a href="#import-popup" class="button-green-white" id="import-popup" style="margin-right:10px;">
                            <i class="fa fa-cloud-upload"></i>
                            Import Seatizen Data
                        </a>
                        
                        <a href="<?php echo base_url(); ?>seatizen/dashboard" class="button-green-white">
                            <i class="fa fa-line-chart"></i>
                            Seatizen Growth
                        </a>
                    </span>
                </h1>
            </div>
            <!-- /.col-md-12 -->
        </div>
        <!-- /.row -->


        <?php show_notification(); ?>


        <div class="row">

            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-body">
                    	

                        <div class="row">
                            <div class="col-md-12">


                                <?php
                                echo form_button(
                                    array(
                                        "class" => "button-green-white ",
                                        "data-toggle" => "modal",
                                        "data-target" => "#block-many-confirmation"
                                    ),
                                    "Block"
                                );
                                ?>

                                <?php
                                echo form_button(
                                    array(
                                        "class" => "button-green-white ",
                                        "data-toggle" => "modal",
                                        "data-target" => "#unblock-many-confirmation"
                                    ),
                                    "Unblock"
                                );
                                ?>

                                <?php
                                echo form_input(
                                    array(
                                        "class" => "search",
                                        "name" => "filter_1",
                                        "placeholder" => "Name"
                                    )
                                );
                                ?>

                                <?php
                                echo form_input(
                                    array(
                                        "class" => "search",
                                        "name" => "filter_2",
                                        "placeholder" => "Email"
                                    )
                                );
                                ?>
                            </div>
                            <!-- /.col-md-12 -->
                        </div>
                        <!-- /.row -->



                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-list">
                                        <thead class="button-green-white">
                                        <tr>
                                            <th style="text-align: center;"><input type="checkbox" onclick="cek_all()" id="cek_all" name="id_all"></th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <!-- <th>Department</th> -->
                                            <th> Rank </th>
                                            <th> Facebook </th>
                                            <th> Google +</th>
                                            <th> Register at</th>
                                            <th>Last Login</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        
                                            foreach ($list_seatizen as $dt) {
                                                # code...

                                                $dtLastLogin = $this->seatizen->lastLoginSeatizen($dt['username']);
                                                // print_r($dtLastLogin);
                                                // echo $dtLastLogin['action_time'];
                                                $dtCrew = $this->seatizen->ViewSeatizenCrew($dt['pelaut_id']);
                                                // print_r($dtCrew)
                                                $department_seatizen = "-";
                                                $arr_dept = array();
                                                $arr_comp = array();
                                                $z=0;
                                                foreach ($dtCrew as $crew) {
                                                    # code...
                                                    $dt_department = $this->department->get_detail_department($crew['department']);
												
													
                                                    $dt_company = $this->seatizen->CompanySeatizen($crew['id_perusahaan']);
                                                    if($z==0)$department_seatizen = "- $dt_department[department] ($dt_company[nama_perusahaan])";
                                                    
                                                    else
                                                    $department_seatizen .= "<br>- $dt_department[department] ($dt_company[nama_perusahaan])";
                                                    $z++;
                                                    
                                                }

                                                $arr_id = array(array("field"=>"id_object","val"=>$dt['pelaut_id']),
                                        array("field"=>"form","val"=>"BLOCKED"));

                                    
                                        $arr_id2 = array(array("field"=>"id_object","val"=>$dt['pelaut_id']),
                                        array("field"=>"form","val"=>"ACTIVE"));
                                            $this->load->library('Admin_activity');
                                        // $arr_id3 = array(array("field"=>"id_object","val"=>$dt['pelaut_id']),
                                        // array("field"=>"form","val"=>"account_type"));
                                        if($dt['activation'] != "ACTIVE"){
                                        $adact      = $this->admin_activity->get_last_action("seatizen",$arr_id);
                                    }else{
                                                $adact      = $this->admin_activity->get_last_action("seatizen",$arr_id2);

                                    }
                                        // $adact_role = $this->admin_activity->get_last_action("agentsea",$arr_id2);
                                        // $adact_at   = $this->admin_activity->get_last_action("agentsea",$arr_id3);
                                        

                                                $status = $dt["activation"];
                                                $class = "style='background-color: orange'";
                                                if($status == "BLOCKED")
                                                {
                                                    $class = "style='background-color: #FF2865; color: black;'";
                                                    $block_state = "glyphicon glyphicon-ok-sign"; $title_block = "unblock";

                                                }
                                                else if($status == "ACTIVE"){
                                                    $class = "";
                                                    $block_state = "glyphicon glyphicon-ban-circle"; $title_block = "block";
                                                }
												
												$rank = $this->rank_model->get_rank_detail_byid($dt["rank"]); 

                                                $data_content = "<div> PIC : ".$adact['username']." </div>".
                                                "<div> on: ".$adact['datetime']." </div> ";
                                                $title_popup = $dt['activation'];
                                                if($dt['activation'] != "ACTIVE" && $dt['activation'] != "BLOCKED"){
                                                    $title_popup = "ACTIVATION CODE";
                                                }

                                                ?>

                                            <tr <?= $class ?>>
                                              <td class="center reference" >
                                                    <input type="checkbox" name="list_checkboxes[]" value="<?=$dt['pelaut_id']?>">
                                                    <span data-toggle="popover" data-content="<?=$data_content?>" 
                                                    title="<?=$title_popup?>" class="ipop"></span>
                                              </td>
                                              <td class="left name" >
                                                <div data-toggle="popover" class="ipop pull-left" data-content="<?=$data_content?>" 
                                                title="<?=$title_popup?>"> 
                                                    <?=$dt['nama_depan']." ".$dt['nama_belakang']?>                                          
                                                </div>
                                              </td>
                                              <td class="left linkable" >
                                                <div data-toggle="popover" class="ipop" data-content="<?=$data_content?>"
                                                title="<?=$title_popup?>"> 
                                                <?=$dt['email']?> </div>
                                              </td>
                                              <!-- <td class="left linkable" >
                                                <div data-toggle="popover" class="ipop" data-content="<?=$data_content?>"
                                                title="<?=$title_popup?>"> 
                                                <?=$department_seatizen?> </div> -->
                                              <td>
                                              	<div data-toggle="popover" class="ipop" data-content="<?=$data_content?>"
                                                title="<?=$title_popup?>"> 
                                                <?=$rank['rank']?> </div>
                                              </td>
                                              <td> <a href="https://www.facebook.com/<?=$dt["facebook_id"]?>" target="_blank"><?=$dt["facebook_id"]?></a> </td>
                                              <td> <a href="https://plus.google.com/<?=$dt["google_id"]?>" target="_blank"><?=$dt["google_id"]?></a> </td>
                                              <!-- <td>
                                              <?php
											  	
											  	$d = $this->experience_model->last_experience($dt["pelaut_id"]);
												
												$vt = $this->vessel_model->get_shiptype_byshipid($d["ship_type_id"]);
											
												echo $vt["ship_type"];
											  ?>
                                              </td> -->
                                              </td>
                                              <td class="left linkable" >
                                                <div data-toggle="popover" class="ipop" data-content="<?=$data_content?>"
                                                title="<?=$title_popup?>"> 
                                                <?=$dt['create_date']?> </div>
                                              </td>
                                              <td class="left linkable">
                                                <div data-toggle="popover" class="ipop" data-content="<?=$data_content;?>"
                                                    title="<?=$title_popup;?>">
                                                    <?php 
                                                if(count($dtLastLogin) != 0){ 
                                                    $xzzz = date('Y-m-d H:i:s');
                                                    $now = new DateTime($xzzz);
                                                    $terakhir = new DateTime($dtLastLogin['action_time']);
                                                    // echo $dtLastLogin['action_time'];
                                                 $difference = $terakhir->diff($now);

                                                    if($difference->d < 1 && $difference->days < 1){
                                                        echo "Today";
                                                    }else if($difference->d > 1 AND $difference->days <= 7){
                                                        echo "This Week";
                                                    }else if($difference->m < 1 AND $difference->days > 7){
                                                        echo "This Month";
                                                    }else if($difference->m >1 AND $difference->y == 0){
                                                        echo "Last Month";
                                                    }else if($difference->y == 1){
                                                        echo "1 years ago";
                                                    }else if($difference->y > 1){
                                                        echo "More than 1 years ago";
                                                    }

                                                }else{
                                                    echo "-";
                                                }
                                                    ?>  
                                            </div>

                                            </td>
                                            <td align="center">
                                            
                                                <a href="<?=base_url("seatizen/log/$dt[pelaut_id]")?>">
                                                  <i class="fa fa-bars"></i>
                                                </a>                                           
                                                &nbsp;
                                                <a href="#" onclick="change_activation(<?=$dt["pelaut_id"]?>)" title="activated seaman">
                                                  <i class="fa fa-edit"></i>
                                                </a>
                                                
                                                <a href="#" onclick="seatizen_delete(<?=$dt["pelaut_id"]?>)" title="delete seaman">
                                                  <i class="glyphicon glyphicon-trash"></i>
                                                </a>
                                               
                                                
                                                <?php if($dt['activation'] == "ACTIVE" || $dt['activation'] == "BLOCKED"){
                                                  ?>
                                                  <a href='#' onclick='blockSeatizen(<?=$dt['pelaut_id']?>)' >
                                                      <i class="<?php echo $block_state ?>" title="<?php echo $title_block ?>"></i>
                                                  </a>
                                                <?php }else if($dt['activation'] != "BLOCKED" || $dt['activation'] != "ACTIVE"){ ?>
                                                  
                                                  <a href="glyphicon glyphicon-ok-circle"> 
                                                    <i class=""></i>
                                                  </a>
                                                
                                                <?php } ?>
                                             
                                                
                                             </td>
                                          </tr>
                                                <?php
                                            }
                                         ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                                
                            </div>
                            <!-- /.col-md-12 -->
                        </div>
                        <!-- /.row -->

						<div id="hidden_seatizen">
                        	<h3> Seatizen hidden : <?=$total_hidden?></h3>
                        </div>
                        
                        <!-- Charts Start Here -->
						<div class="box box-success col-md-6">
			                <div class="box-header">
			                  <h3 class="box-title">Overview Chart</h3>
			                </div>
			                <div class="box-body chart-responsive">
			                  <div id="container-overview-chart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
			                </div><!-- /.box-body -->
                           
		              	</div><!-- /.box -->
                        <div class="box box-success col-md-6">
                        	
                        	 <div class="box-header">
			                  <h3 class="box-title">Overview Chart</h3>
			                </div>
			                <div class="box-body chart-responsive">
			                  <div id="container-chart-seatizen" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
			                </div><!-- /.box-body -->
                        </div>
                    	<!-- Charts End Here -->
                        
                        
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-md-12 -->
        </div>
        <!-- /.row -->

    </div>
    <!-- /#page-wrapper -->


    <?php
    $modal_block_data = array();
    $modal_block_data["route"] = $controller_name;
    $this->load->view("modal/block_confirmation", $modal_block_data);
    $this->load->view("modal/unblock_confirmation", $modal_block_data);
    ?>

    

    <!-- DataTables JavaScript -->
    <script src="<?php echo infr_asset('plugin/highcharts/highcharts.js') ?>"></script>
	<script src="<?php echo infr_asset('plugin/highcharts/modules/data.js') ?>"></script>
    <script src="<?php echo infr_asset('plugin/highcharts/modules/drilldown.js') ?>"></script>
    <script src="<?php echo bower_url(); ?>datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo bower_url(); ?>datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>

    /* Script for Charts Start Here */
    $('#container-overview-chart').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Overview'
        },
        subtitle: {
            text: '<?php echo $namanya ?>'
        },
        xAxis: {
        	type:"category",
            title:{
            	title : "Rank"
            }
        },
        yAxis: {
            title: {
                text: 'Peoples'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true
                }
            }
        },

        /*tooltip: {
          formatter: function() {
            var years = Math.floor((this.y)/365) <= 0 ? 0 : Math.floor((this.y)/365);
            var text_years = years != 0 ? years+'y': '';
            var total_days = years*365;
            var sisa_hari = (this.y) - total_days;
            
            var months = Math.floor(sisa_hari/30) <= 0 ? 0 : Math.floor(sisa_hari/30);
            var text_months = months != 0 && years != 0 ? " "+months+'m': months != 0 && years == 0 ? months+'m': '';
            
            var total_days = months*30;
            var sisa_hari = sisa_hari - total_days;
            // alert(sisa_hari);
            var text_hari = sisa_hari != 0 && ((months != 0 && years != 0) || (months != 0 && years == 0) || (months == 0 && years != 0)) ? " "+sisa_hari+'d': sisa_hari != 0 && months == 0 ? sisa_hari+'d': '';
            
            var total = text_years+text_months+text_hari;
            var name = this.series.name;
            var xx1 = name == "Overview" ? '<br>': 'name : ';
            var xx2 = name == "Overview" ? ':': '<br>';
            var xx3 = name == "Overview" ? '<br>Click column to see detail': '';
            // alert(xx);
            return '<span style="font-size:11px">'+this.series.name+'</span> '+xx1+' <span style="color:'+this.point.color+'">'+this.point.name+'</span>'+xx2+' <b>' + total + '</b>'+xx3;
        }
        },*/

        series: [{
            name: 'Department',
            colorByPoint: true,
            data: [
            <?php 
              $mz=0;
              // $total_days_in_ship = 0;
              /* Seatizen Statisctics Start Here */

              $this->db = $this->load->database(DB2_GROUP, true);


			    $str_dept = "select * from department";
                  $q_dept = $this->db->query($str_dept);
                  $res_dept = $q_dept->result_array();
                  $q_dept->free_result();
                  $jumlah_dept = count($res_dept);

			    $str = "select pms.pelaut_id, rt.rank from pelaut_ms pms join profile_resume_tr rt on rt.pelaut_id = pms.pelaut_id where pms.activation = 'ACTIVE' and pms.`show` = 'TRUE' ";

			    $str_order = "$str ORDER BY create_date ASC, pelaut_id DESC";
			    $q_order = $this->db->query($str_order);
			    $f_order = $q_order->result_array();
			    $q_order->free_result();

			    $jml_seatizen = count($f_order);

			    if($jml_seatizen > 0){
		            $mz=0;
            $dept_tidak_kosong=0;
            foreach($res_dept as $dept)
            {
                //load

                $str_rank = "SELECT * FROM rank WHERE id_department = '$dept[department_id]'";
                $q_rank = $this->db->query($str_rank);
                $res_rank = $q_rank->result_array();
                $q_rank->free_result();
                $dept_index_name = str_replace(' ', '_', $dept['department']);
                $seatizen_on_rank[$dept_index_name] = array();
                $jml_seatizen_per_rank=0;
                foreach ($res_rank as $row) {
                  
                  $str_vacperrank = $str." AND rank = '$row[rank_id]' ";
                  $q_vacperrank = $this->db->query($str_vacperrank);
                  $f_vacperrank = $q_vacperrank->result_array();
                  $q_vacperrank->free_result();

                  if($f_vacperrank == null) continue;

                  $rank_index_name = str_replace(' ', '_', $row['rank']);
                  $seatizen_on_rank[$dept_index_name][$rank_index_name] = count($f_vacperrank);
                  $jml_seatizen_per_rank += count($f_vacperrank);
                  // $percent = ($jml_vacperrank / $jml_vacantsea) * 100;
                  // echo "jml_vacant_per_rank['".str_replace(' ', '_', $rank['rank'])."'] = $jml_vacperrank;\n";
                  // $data_vacant_per_rank[str_replace(' ', '_', $rank['rank'])] = $percent;
                  
                }
                $tmbhan_array = "";
                if($jml_seatizen_per_rank > 0){
                  $dept_tidak_kosong++;
                  $tmbhan_array = ",
                  drilldown : $dept[department_id]
                  ";
                }

                echo "{
                    name : '$dept[department]',
                    y : $jml_seatizen_per_rank$tmbhan_array
                  }";
                  if($mz != ($jumlah_dept-1)) echo ", ";
                  $mz++;
                

            }
            // print_r($data);
		        }
              
            ?>
           /* {
                name: 'Ship',
                y: <?php echo $total_days_in_ship ?>,
                drilldown: 'Ship Type'
            }, {
                name: 'Rank',
                y: <?php echo $total_days_in_rank ?>,
                drilldown: 'Rank'
            }, {
                name: 'Join Since',
                y: <?php echo $join_since ?>
            }]*/]
        }],
        drilldown: {
            series: [
            <?php 
              // print_r($seatizen_on_rank);
              $counter_dept = 0;
              foreach ($res_dept as $val) {
                $dept_index_name = str_replace(' ', '_', $val['department']);
                  if($seatizen_on_rank[$dept_index_name] == null) continue;
                echo "{
                  name: '$val[department]',
                  id  : $val[department_id],
                  data: [";
                  
                  $jml_seatizen = count($seatizen_on_rank[$dept_index_name]);
                  $counter_data = 0;
                  foreach ($seatizen_on_rank[$dept_index_name] as $key => $value) {
                    echo "['$key', $value]";
                    if($counter_data != ($jml_seatizen-1)) echo ", ";
                    $counter_data++;
                    

                  }
                echo "]
                }";
                if($counter_dept != ($dept_tidak_kosong-1)) echo ", ";
                $counter_dept++;
              }

               ?>
            ]
        }
    }); 
	/* Script Charts End Here */
		function form_seatizen_add()
		{
			
			$.ajax({
				
				type:"POST",
				url:"<?=base_url("seatizen/form_seatizen_add")?>",
				data:"x=1",
				success:function(data){
					
					$(".seatizen-modal-temp").html(data);
				}
				
			});
			
		}	
		
		function seatizen_delete(id_seatizen)
		{
			$.ajax({
				
				type:"POST",
				url:"<?=base_url("seatizen/seatizen_delete")?>",
				data:"id_seatizen="+id_seatizen,
				success: function(data)
				{
					$(".seatizen-modal-temp").html(data);
					
				}
				
			})	
			
		}

        function cek_all () {
                // body...
                var state = $("#cek_all").prop("checked");
                $("#dataTables-list").parent().find(".reference").find("input[name=list_checkboxes\\[\\]]").prop("checked", state);
        }
		
        var source 		 = "<?php echo isset($dt_list_source) ? $dt_list_source : ""; ?>";
        var baseURL 	    = "<?php echo $base_url; ?>";
        var tableName 	  = "<?php echo $table_name; ?>"; // for bulk action
        var controllerName = "<?php echo $controller_name; ?>"; // for link to page detail
        var oTable 		 = null;

        var csrfTokenName = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

        var settings = {
            processing: true,
            autoWidth: false,
            // ajax: {
            //     url: source,
            //     type: "POST",
            //     data: function(data) {
            //         data.token_field = csrfHash;
            //     }
            // },
            // serverSide: true,
            lengthChange: false,
            columnDefs:[{orderable: false, targets: [0]}],
            searching: true,
            pageLength: 10,
            dom: '<"H"r>t<"F"ip>',
            // order: [
            //     [1, 'asc']
            // ]
            // columns: [
            //     { visible: true, searchable: false, orderable: false, className: "center reference", width: "3%", data: "checkbox"},

            //     { visible: true, searchable: true, orderable: true, className: "left linkable name", width: "23%", data: "name", name: "name"},
            //     { visible: true, searchable: true, orderable: true, className: "left linkable", width: "20%", data: "email", name: "email"},
            //     { visible: true, searchable: true, orderable: true, className: "left linkable", width: "20%", data: "department", name: "department"},
            //     { visible: true, searchable: true, orderable: true, className: "left linkable", width: "20%", data: "gender", name: "gender"},
            //     { visible: true, searchable: true, orderable: true, className: "left linkable", width: "8%", data: "status", name: "status"},

            //     { visible: true, searchable: false, orderable: false, className: "left", width: "3%", data: "log_link"},
            //     { visible: true, searchable: false, orderable: false, className: "left", width: "3%", data: "block_link"}
            // ],
            responsive: true,
            drawCallback: function() {


                listCheckboxes = {};
                $("input[name=id_all]").prop("checked", false);
            }
        };

        

        $(document).ready(function () {
            // alert("document eady");

            $(".role-popover").popover({
                trigger   :'hover',
                'placement'  :'top',
                animation   :true,
                //container :false,
                title       :'info',
                
                delay       :1, // { "show": 500, "hide": 100 }
                html         :true,
                //placement:'right',
                //'selector':'false',
                template:'<div class="popover col-md-4" style="border:1px solid #CCC" ><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
                
                //viewport:{ selector: 'body', padding: 0 }
                
            });
            
            $(".ipop").popover({
                trigger   :'hover',
                'placement'  :'top',
                animation   :true,
                //container :false,
                title       :'Info',
                delay       :1, // { "show": 500, "hide": 100 }
                html         :true,
                //placement:'right',
                //'selector':'false',
                template:'<div class="popover col-md-4" style="border:1px solid #CCC" ><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
                
                //viewport:{ selector: 'body', padding: 0 }
            });

            oTable = $('#dataTables-list').DataTable(settings);

            // alert("saya berubah");

            $("input[name=filter_1]").on("keyup change", function () {
                // alert("saya berubah");
                oTable.column(1).search($(this).val()).draw();
            });

            $("input[name=filter_2]").on("keyup change", function () {
                oTable.column(2).search($(this).val()).draw();
            });
			
			$("input[name=filter_8]").on("keyup change", function () {
                oTable.column(5).search($(this).val()).draw();
            });

            

            $("#dataTables-list").on("click", "td.linkable", function () {
                var reference = $(this).parent().find(".reference").find("input[name=list_checkboxes\\[\\]]").val();
                //document.location.href = baseURL + controllerName + "/detail/page/" + reference;
				

				window.open(
				  baseURL + controllerName + "/detail/page/" + reference,
				  '_blank' // <- This is what makes it open in a new window.
				);


            });
			
			// trigger file upload to show.
            $("#import-popup").click(function() {
                $("input[name=excel_file]").click();
            });

            $("input[name=excel_file]").change(function() {

                if ($(this).val() != "") {

                    var uploadOptions = {
                        success: function(data) {
							
							//alert(data);
							
                            var result = data;

                            if (result.status == "error") {

                                showNotification("danger", result.notification);

                            } else {

                                showNotification("success", result.notification);

                                // redraw datatable,
                                oTable.draw();
                            }
                        },
                        error: function(data) {

                            console.log(data);
                            showNotification("danger", result.notification);
//                            location.reload();
                        }
                    };

                    $("#form-upload-seatizen").ajaxForm(uploadOptions);
                    $("#form-upload-seatizen").submit();


                    $(this).val("");

                    return false;
                }
            });
        });

    </script>
    
    <script>
		<?php

			$username   = $this->session->userdata("username_company");
		
			/* Job Statistics Data Start Here */
		
			$this->load->model("Rank_model");
			$this->load->model("Department_model");
	
			$str_general = "SELECT vacantsea.*, perusahaan.id_perusahaan, perusahaan.activation_code FROM vacantsea,perusahaan WHERE perusahaan.id_perusahaan = vacantsea.id_perusahaan AND perusahaan.activation_code = 'ACTIVE' AND perusahaan.tampil = 1 AND vacantsea.stat = 'open' ";

			$str_vac = "$str_general ORDER BY create_date ASC, vacantsea_id DESC";
		
			$q_vac = $this->db->query($str_vac);
		
			$f_vac = $q_vac->result_array();
		
			// GROUP BY RANK
		
			$str_gvac = "$str_general GROUP BY rank_id ORDER BY create_date ASC, vacantsea_id DESC";
		
			$q_gvac = $this->db->query($str_gvac);
		
			$f_gvac = $q_gvac->result_array();
		
			$jml_vacantsea = count($f_vac);

			/* Job Statistics End Here */

			/* Seatizen Statisctics Start Here */
		
			$str_rank = "select * from rank";
		
			$q_rank = $this->db->query($str_rank);
		
			$f_rank = $q_rank->result_array();
		
			$str = "select 
			pms.pelaut_id, 
			rt.rank 
			
			from 
			
			pelaut_ms pms join profile_resume_tr rt on rt.pelaut_id = pms.pelaut_id 
			
			where pms.activation = 'ACTIVE' and pms.`show` = 'TRUE' ";

			$str_order = "$str ORDER BY create_date ASC, pelaut_id DESC";
		
			$q_order = $this->db->query($str_order);
		
			$f_order = $q_order->result_array();

			$jml_seatizen = count($f_order);
		
			/* Seatizen Statistics End Here */
		
		?>
		
		

// alert("<?php echo date('Y-m-d') ?>");

var jml_vacant_per_rank = new Array();

var jml_seatizen_per_rank = new Array();

   $(function () {

    <?php

        if($jml_seatizen > 0){

            $data_seatizen_per_rank = array();

            foreach ($f_dept as $value) {

                $str_searank = "$str and rt.department = $value[department_id]";

                $q_searank = $this->db->query($str_searank);

                $f_searank = $q_searank->result_array();



                if($f_searank == null) continue;



                $jml_searank = count($f_searank);

                $percent = ($jml_searank / $jml_seatizen) * 100;

                echo "jml_seatizen_per_rank['".str_replace(' ', '_', $value['department'])."'] = $jml_searank;\n";

                $data_seatizen_per_rank[str_replace(' ', '_', $value['department'])] = $percent;

            }

        }



        if($jml_vacantsea > 0){

            $data_vacant_per_rank = array();

            

            foreach($f_gvac as $row)

            {

                //load

                $rank = $this->rank_model->get_rank_detail_byid($row["rank_id"]);

                $department = $this->department_model->get_detail_department($rank["id_department"]);

                

                $str_vacperrank = $str_general." AND department = '$row[department]' ";

                $q_vacperrank = $this->db->query($str_vacperrank);

                $f_vacperrank = $q_vacperrank->result_array();

                

                $jml_vacperrank = count($f_vacperrank);

                $percent = ($jml_vacperrank / $jml_vacantsea) * 100;

                echo "jml_vacant_per_rank['".str_replace(' ', '_', $department['department'])."'] = $jml_vacperrank;\n";

                $data_vacant_per_rank[str_replace(' ', '_', $department['department'])] = $percent;



            }

            // print_r($data);

        }

            

    ?>



    <?php 

    // print_r($allCrewCompany);

    

    if($jml_seatizen > 0){ ?>

    $('#container-chart-seatizen').highcharts({

        chart: {

            plotBackgroundColor: null,

            plotBorderWidth: null,

            plotShadow: false,

            type: 'pie'

        },

        title: {

            text: 'Seatizen'

        },

        tooltip: {

        

            formatter: function () {

                // body...

                var name = this.point.name;

                name_space = name.replace(/\s/g, '_');

                var value = jml_seatizen_per_rank[name_space];

                value = value > 1 ? value+" peoples" : value+" people";

                var pesan = name+": <b>"+value+"</b>";

                // console.log(name+" -> "+name_space);

                return pesan;

            }

        },

        plotOptions: {

            pie: {

                allowPointSelect: true,

                cursor: 'pointer',

                dataLabels: {

                    enabled: true,

                    format: '<b>{point.name}</b>: {point.y:.2f}%',

                    style: {

                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'

                    }

                }

            }

        },

        series: [{

            name: 'Total',

            colorByPoint: true,

            data: [

            <?php 

            $z=0;

            $jml_total = count($data_seatizen_per_rank);

            foreach ($data_seatizen_per_rank as $key => $value) {

                $key = str_replace('_', ' ', $key);

                echo "{

                    name : '$key',

                    y : $value

                }";

                if(($jml_total-1) != $z) echo ", ";

                $z++;



            }

            

            ?>

            ]

        }]

    });

    <?php } ?>



    <?php 

    // print_r($allCrewCompany);

    

    if($jml_vacantsea > 0){ ?>

    $('#container-chart-job').highcharts({

        chart: {

            plotBackgroundColor: null,

            plotBorderWidth: null,

            plotShadow: false,

            type: 'pie'

        },

        title: {

            text: 'Job'

        },

        tooltip: {

        

            formatter: function () {

                // body...

                var name = this.point.name;

                name_space = name.replace(/\s/g, '_');

                var value = jml_vacant_per_rank[name_space];

                value = value > 1 ? value+" jobs" : value+" job";

                var pesan = name+": <b>"+value+"</b>";

                // console.log(name+" -> "+name_space);

                return pesan;

            }

        },

        plotOptions: {

            pie: {

                allowPointSelect: true,

                cursor: 'pointer',

                dataLabels: {

                    enabled: true,

                    format: '<b>{point.name}</b>: {point.y:.2f}%',

                    style: {

                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'

                    }

                }

            }

        },

        series: [{

            name: 'Total',

            colorByPoint: true,

            data: [

            <?php 

            $z=0;

            $jml_total = count($data_vacant_per_rank);

            foreach ($data_vacant_per_rank as $key => $value) {

                $key = str_replace('_', ' ', $key);

                echo "{

                    name : '$key',

                    y : $value

                }";

                if(($jml_total-1) != $z) echo ", ";

                $z++;



            }

            

            ?>

            ]

        }]

    });

    <?php } ?>

});
	
	</script>
    <script>alert("hei")</script>

<?php echo js("bulk_action.js"); ?>

<?php $this->load->view("element/footer"); ?>