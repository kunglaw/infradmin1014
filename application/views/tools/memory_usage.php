
<?php $this->load->view("element/header"); ?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header">
                    DATABASE USAGE
                </h1>
            </div>
            <!-- /.col-md-12 -->
        </div>
        <!-- /.row -->
		
        <?php
		$i = 0;
		foreach($db as $database){
		?>
        	<div class="row">

            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-body">
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-md-12">
                            	<h3> <?php echo $database['database']['table_schema'] ?></h3>
                                Database Usage: <?php echo round(floatval($database['database']["size"]), 4); ?> MB
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-md-12">

                                <table class="company-detail">
                                    <thead class="button-green-white">
                                    <tr>
                                        <td>
                                            Table
                                        </td>
                                        <td>
                                            Memory Usage (in MB)
                                        </td>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php foreach($database['table'] as $element): ?>

                                        <tr>
                                            <td><?php echo $element["table_name"]; ?></td>
                                            <td><?php echo round(floatval($element["size"]), 4); ?></td>
                                        </tr>

                                    <?php endforeach; ?>

                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-md-12">
                                Database Usage: <?php echo round(floatval($database['database']["size"]), 4); ?> MB
                            </div>
                        </div>

                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-md-12 -->
        </div>
        <!-- /.row -->
        <?php
		$i++;
		}
		?>

    </div>
    <!-- /#page-wrapper -->

<?php $this->load->view("element/footer"); ?>