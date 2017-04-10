<?php

/**

 * Created by PhpStorm.

 * User: pulung

 * Date: 29/10/14

 * Time: 13:00

 */

?>

<?php $this->load->view("element/header"); ?>

    <!-- DataTables CSS -->

    <link href="<?php echo bower_url(); ?>datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">



    <!-- DataTables Responsive CSS -->

    <link href="<?php echo bower_url(); ?>datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">

	
	<script>
		function delete_vacantsea(vacantsea_id)
		{
			
			
			$.ajax({
				type:"POST",
				url:"<?=base_url("vacantsea/delete_vacantsea_modal")?>",
				data:"vacantsea_id="+vacantsea_id,
				success: function(data)
				{
					$(".temp-vacantsea").html(data);
				}
					
			});
			
			
			
		}
	</script>
	


    <div id="page-wrapper">

    	<div class="temp-vacantsea"></div>

        <div class="row">

            <div class="col-md-12">

                <h1 class="page-header">

                    VACANTSEA MANAGEMENT



                    <span class="pull-right">

                        <a href="<?php echo base_url(); ?>vacantsea/dashboard" class="button-green-white">

                            <i class="fa fa-line-chart"></i>

                            Vacantsea Growth

                        </a>

                    </span>

                </h1>

            </div>

            <!-- /.col-md-12 -->

        </div>

        <!-- /.row -->

        <?php show_notification(); ?>

        <ul class="nav nav-tabs" role="tablist">

          <li role="presentation" class="<?=$list_active?>">

            <a href="<?=base_url("vacantsea?tab=list")?>"  >

                <b> Vacantsea List </b>

            </a> 

          </li>

          <li role="presentation" class="<?=$app_active?>">

            <a href="<?=base_url("vacantsea?tab=app")?>"  >

                <b>  Applicant list </b>

            </a>

          </li>

          <li role="presentation" class="<?=$post_active?>">

            <a href="<?=base_url("vacantsea?tab=post")?>"  ><b>Post</b></a> 

          </li>

          

          <li role="presentation" class="<?=$post_scrap_active?>">

            <a href="<?=base_url("vacantsea?tab=post_scrap")?>"  ><b>Post Scrap</b></a> 

          </li>

        

        </ul>

        

        <div class="tab-content">

        	<?php if($list_active == "active"){ ?>

              <div role="tabpanel" class="tab-pane <?=$list_active?>" id="list">

              	  <br>

                  <div class="row">

          

                      <div class="col-md-12">

                          <div class="panel panel-default">

          

                              <div class="panel-body">

                                  

                                  <div class="row">

                                      <div class="col-md-12">

          

                                          <?php

                                          echo form_input(

                                              array(

                                                  "class" => " search",

                                                  "name" => "filter_1",

                                                  "placeholder" => "Name"

                                              )

                                          );

                                          ?>

          

                                          <?php

                                          echo form_input(

                                              array(

                                                  "class" => " search",

                                                  "name" => "filter_2",

                                                  "placeholder" => "Company"

                                              )

                                          );

                                          ?>

          

                                          <?php

                                          echo form_input(

                                              array(

                                                  "class" => " search",

                                                  "name" => "filter_3",

                                                  "placeholder" => "Department"

                                              )

                                          );

                                          ?>

          

                                          <?php

                                          echo form_input(

                                              array(

                                                  "class" => " search",

                                                  "name" => "filter_4",

                                                  "placeholder" => "Rank"

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

                                                      <th style="text-align: center;"><input type="checkbox" name="id_all"></th>

                                                      <th>Title</th>

                                                      <th>Company</th>

                                                      <th>Department</th>

                                                      <th>Rank</th>

                                                      <th>Create Date</th>

                                                      <th>Expired Date</th>

                                                      <th>Applicant</th>

                                                      <th>View</th>

                                                      <th></th>

                                                  </tr>

                                                  </thead>

                                                  <tbody>

                                                  	<?php foreach($list_vacantsea as $row){ 

													

														$company = $this->agentsea_model->detail_agentsea($row["id_perusahaan"]);

														

														if($row["admin_post"] > 0)

														{

															// get data admin

															$stra = "SELECT * FROM admin_user WHERE id = '$row[admin_post]' ";

															$qa   = $this->db->query($stra);

															$fa   = $qa->row_array();

															

															$pic = $fa["name"]." ( admin )";  

														}

														else

														{

															$pic = $company["contact_person"];	

														}

														

														$data_content = "<div> PIC : $pic </div>". 

                                        				" <div> on: $row[create_date] </div>";

													

													?>

                                                     <tr>

                                                  	  <td class="center reference">

                                                      	<input type="checkbox" value="<?=$row['vacantsea_id']?>" name="list_checkboxes[]">

                                                      	<?=$row['vacantsea_id']?>

                                                      </td>

                                                      <td class="">

                                                       <a href="<?=base_url("vacantsea/detail/page/$row[vacantsea_id]")?>" target="_blank" > 

                                                      	<span data-toggle="popover" data-content="<?=$pic?>" 

                                                        title="Update" class="ipop"> 

                                                        <?php echo $row['vacantsea'] ?> </span>

													   </a>

                                                      </td>

                                                      <td class="linkable"> 

                                                      	<span data-toggle="popover" data-content="<?=$data_content?>" 

                                                        title="Update" class="ipop"> 

													  	<?php 

															
															if($company["id_perusahaan"] == 0)
															{
																$company_name = $row["perusahaan"];
															}
															else
															{
																$company_name = $company['nama_perusahaan'];
															}
															
															echo $company_name;

														?>

                                                        </span>

                                                      </td>

                                                      <td class=""> 

                                                      	<span data-toggle="popover" data-content="<?=$data_content?>" 

                                                        title="Update" class="ipop"> 

													  	<?php

															$department = $this->department_model->get_detail_department($row['department']); 

															echo $department["department"]  

														?>

                                                        </span>

                                                      </td>

                                                      <td class="">

                                                      	<span data-toggle="popover" data-content="<?=$data_content?>" 

                                                        title="Update" class="ipop"> 

                                                      	 <?php

														 	$rank = $this->rank_model->get_rank_detail_byid($row['rank_id']); 

														 	echo $rank['rank'] 

														 ?>

                                                         </span>

                                                      </td>

                                                      <td class=""> 

                                                      	 <span data-toggle="popover" data-content="<?=$data_content?>" 

                                                        title="Update" class="ipop"> 

													  	 <?php echo $row['create_date'] ?>

                                                         </span>

                                                      </td>

                                                      <td class=""> 

                                                      	 <span data-toggle="popover" data-content="<?=$data_content?>" 

                                                        title="Update" class="ipop"> 

													  	 <?php echo $row['expired_date'] ?>

                                                         </span>

                                                      

                                                      </td>

                                                      <td class=""> 

                                                      	<span data-toggle="popover" data-content="<?=$data_content?>" 

                                                        title="Update" class="ipop"> 

													  	<?php 

															

															$applicant = $this->vacantsea->applicant_list($row['vacantsea_id']);

															echo count($applicant). " Applicant"; 

															

														?>

                                                        </span>

                                                      </td>

                                                      <td class=""> 

                                                      	<span data-toggle="popover" data-content="<?=$data_content?>" 

                                                        title="Update" class="ipop"> 
															
                                                            
													  	<?php 

															$view = $this->vacantsea->log_vacantsea($row['vacantsea_id']); 

															echo "<div style='width:100%; '>

															<span style='width:30%' class='pull-left'>".count($view)."</span>&nbsp;

															<span style='width:70%' clas='pull-right'>Views</span>

															</div>";  

														?>

                                                        </span>

                                                      </td>

                                                      <td> 
                                                      	  <div class="btn-group">
                                                              
                                                              <button type="button" class="btn btn-default dropdown-toggle" 
                                                              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                               <span class="glyphicon glyphicon-cog"></span> Setting <span class="caret"></span>
                                                              </button>
                                                              <ul class="dropdown-menu pull-right">
                                                              	<li>
                                                                  <a href="<?=base_url()."vacantsea/viewer/$row[vacantsea_id]" ?>" ><i class="fa fa-users"></i>
                                                                  	Viewer 
                                                                  </a>
                                                                </li>
                                                                <li><a href="#" id="delete-vacantsea" onClick="delete_vacantsea(<?=$row["vacantsea_id"]?>)"><i class="glyphicon glyphicon-trash"></i> Delete </a></li>
                                                                
                                                              </ul>
                                                            </div>
                                                      	  

                                                      </td>

                                                     </tr>

                                                    <?php } ?>

                                                  </tbody>

                                              </table>

                                          </div>

                                          <!-- /.table-responsive -->

                                      </div>

                                      <!-- /.col-md-12 -->

                                  </div>

                                  <!-- /.row -->

                                  <!-- Charts Start Here -->

                      

                                  <div class="box box-success">

                                        <div class="box-header">

                                          <h3 class="box-title">Overview Chart</h3>

                                        </div>

                                        <div class="box-body chart-responsive">

                                          <div id="container-overview-chart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

                                        </div><!-- /.box-body -->

                                    </div><!-- /.box -->

                                  <!-- Charts End Here -->

          

                              </div>

                              <!-- /.panel-body -->

                          </div>

                          <!-- /.panel -->

                      </div>

                      <!-- /.col-md-12 -->

                  </div>

              </div>

            <?php } ?>

            <?php if($app_active == "active"){ ?>

              <div role="tabpanel" class="tab-pane <?=$app_active?>" id="list">

              	  <br>

              	  <?php $this->load->view("vacantsea/applicant_list"); ?>

              </div>

            <?php } ?>

            <?php if($post_active == "active"){ ?>

              <div role="tabpanel" class="tab-pane <?=$post_active?>" id="list">

              	  <br>

              	  <?php $this->load->view("vacantsea/post_vacantsea"); ?>

              </div>

            <?php } ?>

            <?php if($post_scrap_active == "active"){ ?>

              <div role="tabpanel" class="tab-pane <?=$post_scrap_active?>" id="list">

              	  <br>

              	  <?php $this->load->view("vacantsea/post_scrap_vacantsea"); ?>

              </div>

            <?php } ?>

            

        </div>

        

        <!-- /.row -->



    </div>

    <!-- /#page-wrapper -->



    <script src="<?php echo infr_asset('plugin/highcharts/highcharts.js') ?>"></script>

    <script src="<?php echo infr_asset('plugin/highcharts/modules/data.js') ?>"></script>

    <script src="<?php echo infr_asset('plugin/highcharts/modules/drilldown.js') ?>"></script>

    <!-- DataTables JavaScript -->

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

                text: 'Jobs'

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

              

              // $total_days_in_ship = 0;

              /* Seatizen Statisctics Start Here */

              $this->db = $this->load->database(DB2_GROUP, true);

              $str_dept = "select * from department";

              $q_dept = $this->db->query($str_dept);

              $res_dept = $q_dept->result_array();

              $q_dept->free_result();

              $jumlah_dept = count($res_dept);

			  

              $str_general = "SELECT vacantsea.*, perusahaan.id_perusahaan, perusahaan.activation_code FROM vacantsea,perusahaan WHERE perusahaan.id_perusahaan = vacantsea.id_perusahaan AND perusahaan.activation_code = 'ACTIVE'";// AND perusahaan.tampil = 1 AND vacantsea.stat = 'open' ";

              

              $str_vac = "$str_general ORDER BY create_date ASC, vacantsea_id DESC";

              $q_vac = $this->db->query($str_vac);

              $f_vac = $q_vac->result_array();

              $q_vac->free_result();

              



              // GROUP BY RANK

              $str_gvac = "$str_general GROUP BY rank_id ORDER BY create_date ASC, vacantsea_id DESC";

              $q_gvac = $this->db->query($str_gvac);

              $f_gvac = $q_gvac->result_array();

              $q_gvac->free_result();

              

              

              $jml_vacantsea = count($f_vac);



          if($jml_vacantsea > 0){

            // $data_vacant_per_rank = array();

            

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

                $vacantsea_on_rank[$dept_index_name] = array();

                $jml_vacant_per_rank=0;

				

				// list rank per department 

                foreach ($res_rank as $row) {

                  

                  $str_vacperrank = $str_general." AND rank_id = '$row[rank_id]' ";

                  $q_vacperrank = $this->db->query($str_vacperrank);

                  $f_vacperrank = $q_vacperrank->result_array(); // data vacantsea per rank 

                 // $q_vacperrank->free_result();



                  if($f_vacperrank == null) continue;



                  $rank_index_name = str_replace(' ', '_', $row['rank']);

                  $vacantsea_on_rank[$dept_index_name][$rank_index_name] = count($f_vacperrank);

				  

                  $jml_vacant_per_rank += count($f_vacperrank); // jumlah vacantsea per rank 

                  // $percent = ($jml_vacperrank / $jml_vacantsea) * 100;

                  // echo "jml_vacant_per_rank['".str_replace(' ', '_', $rank['rank'])."'] = $jml_vacperrank;\n";

                  // $data_vacant_per_rank[str_replace(' ', '_', $rank['rank'])] = $percent;

                  

                }

                $tmbhan_array = "";

                if($jml_vacant_per_rank > 0){

                  $dept_tidak_kosong++;

                  $tmbhan_array = ",

                  drilldown : $dept[department_id]

                  ";

                }



                echo "{

                    name : '$dept[department]',

                    y : $jml_vacant_per_rank$tmbhan_array

                  }";

                  if($mz != ($jumlah_dept-1)) echo ", ";

                  $mz++;

                



            }

            // print_r($data);

        }

              

            ?>]

        }],

        drilldown: {

            series: [

              <?php 

              // print_r($vacantsea_on_rank);

              $counter_dept = 0;

              foreach ($res_dept as $val) {

                $dept_index_name = str_replace(' ', '_', $val['department']);

                  if($vacantsea_on_rank[$dept_index_name] == null) continue;

                echo "{

                  name: '$val[department]',

                  id  : $val[department_id],

                  data: [";

                  

                  $jml_vacantsea = count($vacantsea_on_rank[$dept_index_name]);

                  $counter_data = 0;

                  foreach ($vacantsea_on_rank[$dept_index_name] as $key => $value) {

                    echo "['$key', $value]";

                    if($counter_data != ($jml_vacantsea-1)) echo ", ";

                    $counter_data++;

                    



                  }

                echo "]

                }";

                if($counter_dept != ($dept_tidak_kosong-1)) echo ", ";

                $counter_dept++;

              }



               ?>]

        }

      });

    

  /* Script Charts End Here */

        var source = "<?php echo isset($dt_list_source) ? $dt_list_source : ""; ?>";

        var baseURL = "<?php echo $base_url; ?>";

        var tableName = "<?php echo $table_name; ?>"; // for bulk action

        var controllerName = "<?php echo $controller_name; ?>"; // for link to page detail

        var oTable = null;



        var csrfTokenName = '<?php echo $this->security->get_csrf_token_name(); ?>';

        var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';



        var settings = {

            processing: true,

            autoWidth: false,

            /* ajax: {

                url: source,

                type: "POST",

                data: function(data) {

                    data.token_field = csrfHash;

                }

            },*/

            //serverSide: true,

            lengthChange: false,

            searching: true,

            pageLength: 10,

            dom: '<"H"r>t<"F"ip>',

            order: [

                [0, 'desc']

            ],

            /*columns: [

                { visible: true, searchable: false, orderable: false, className: "center reference", width: "2%", data: "checkbox"},



                { visible: true, searchable: true, orderable: true, className: "left linkable name", width: "15%", data: "name", name: "name"},

                { visible: true, searchable: true, orderable: true, className: "left linkable", width: "12%", data: "company", name: "company"},

                { visible: true, searchable: true, orderable: true, className: "left linkable", width: "12%", data: "department", name: "department"},

                { visible: true, searchable: true, orderable: true, className: "left linkable", width: "12%", data: "rank", name: "rank"},

                { visible: true, searchable: true, orderable: true, className: "left linkable", width: "12%", data: "create_date", name: "create_date"},

                { visible: true, searchable: true, orderable: true, className: "left linkable", width: "12%", data: "expired_date", name: "expired_date"},

                { visible: true, searchable: true, orderable: true, className: "left linkable", width: "10%", data: "salary", name: "salary"},

                { visible: true, searchable: true, orderable: true, className: "left linkable", width: "10%", data: "view", name: "view"},



                { visible: true, searchable: false, orderable: false, className: "left", width: "3%", data: "log_link"}

            ],*/

            responsive: true,

            drawCallback: function() {



                listCheckboxes = {};

                $("input[name=id_all]").prop("checked", false);

            }

        };

		

		var settings2 = {

            processing: true,

            autoWidth: false,

            /* ajax: {

                url: source,

                type: "POST",

                data: function(data) {

                    data.token_field = csrfHash;

                }

            },*/

            //serverSide: true,

            lengthChange: false,

            searching: true,

            pageLength: 10,

            dom: '<"H"r>t<"F"ip>',

            order: [

                [0, 'desc']

            ],

            /*columns: [

                { visible: true, searchable: false, orderable: false, className: "center reference", width: "2%", data: "checkbox"},



                { visible: true, searchable: true, orderable: true, className: "left linkable name", width: "15%", data: "name", name: "name"},

                { visible: true, searchable: true, orderable: true, className: "left linkable", width: "12%", data: "company", name: "company"},

                { visible: true, searchable: true, orderable: true, className: "left linkable", width: "12%", data: "department", name: "department"},

                { visible: true, searchable: true, orderable: true, className: "left linkable", width: "12%", data: "rank", name: "rank"},

                { visible: true, searchable: true, orderable: true, className: "left linkable", width: "12%", data: "create_date", name: "create_date"},

                { visible: true, searchable: true, orderable: true, className: "left linkable", width: "12%", data: "expired_date", name: "expired_date"},

                { visible: true, searchable: true, orderable: true, className: "left linkable", width: "10%", data: "salary", name: "salary"},

                { visible: true, searchable: true, orderable: true, className: "left linkable", width: "10%", data: "view", name: "view"},



                { visible: true, searchable: false, orderable: false, className: "left", width: "3%", data: "log_link"}

            ],*/

            responsive: true,

            drawCallback: function() {



                listCheckboxes = {};

                $("input[name=id_all]").prop("checked", false);

            }

        }

		

        $(document).ready(function () {

			

			 //$("h1").mouseenter(function(){ alert("hello"); });

			  // INGA2, HARUS CLASSSSSSS

			  $(".role-popover").popover({

				  trigger	  :'hover',

				  'placement'  :'top',

				  animation	:true,

				  //container	:false,

				  title		:'info',

				  

				  delay		:1, // { "show": 500, "hide": 100 }

				  html		 :true,

				  //placement:'right',

				  //'selector':'false',

				  template:'<div class="popover col-md-4" style="border:1px solid #CCC" ><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'

				  

				  //viewport:{ selector: 'body', padding: 0 }

				  

			  });

			  

			  $(".ipop").popover({

				  trigger	  :'hover',

				  'placement'  :'top',

				  animation	:true,

				  //container	:false,

				  title		:'Info',

				  delay		:1, // { "show": 500, "hide": 100 }

				  html		 :true,

				  //placement:'right',

				  //'selector':'false',

				  template:'<div class="popover col-md-4" style="border:1px solid #CCC" ><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'

				  

				  //viewport:{ selector: 'body', padding: 0 }

			  });

			

            oTable = $('#dataTables-list').DataTable(settings);

			oTable2 = $('#dataTables-list2').DataTable(settings2);



            $("input[name=filter_1]").on("keyup change", function () {

                oTable.column(1).search($(this).val()).draw();

            });



            $("input[name=filter_2]").on("keyup change", function () {

                oTable.column(2).search($(this).val()).draw();

            });



            $("input[name=filter_3]").on("keyup change", function () {

                oTable.column(3).search($(this).val()).draw();

            });



            $("input[name=filter_4]").on("keyup change", function () {

                oTable.column(4).search($(this).val()).draw();

            });

			

			// ==================================================

			

			$("input[name=filter_5]").on("keyup change", function () {

                oTable2.column(1).search($(this).val()).draw();

            });

			

			$("input[name=filter_6]").on("keyup change", function () {

                oTable2.column(4).search($(this).val()).draw();

            });

			

			$("input[name=filter_7]").on("keyup change", function () {

                oTable2.column(2).search($(this).val()).draw();

            });



            $("#dataTables-list").on("click", "td.linkable", function () {

                var reference = $(this).parent().find(".reference").find("input[name=list_checkboxes\\[\\]]").val();

                document.location.href = baseURL + controllerName + "/detail/page/" + reference;

            });

			

			 $("#dataTables-list2").on("click", "td.linkable", function () {

                var reference = $(this).parent().find(".reference").find("input[name=list_checkboxes\\[\\]]").val();

                document.location.href = baseURL + controllerName + "/detail/page/" + reference;

            });

        });



    </script>



<?php echo js("bulk_action.js"); ?>



<?php $this->load->view("element/footer"); ?>