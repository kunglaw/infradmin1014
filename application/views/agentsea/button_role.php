<!-- <a href="#" class="btn btn-default" onclick="edit_role(<?=$edit_form?>)">
	<?=$role?>
</a> -->

<!-- <script>
	var edit_form = <?=$edit_form?>;
	var role = "<?=$role?>";
	var ac = "<?=$ac?>";
	
	if(ac == "ACTIVE")
	{
		$(".btn-role-play").html("active <a href='#' class='btn btn-default' onclick='edit_role(<?=$edit_form?>)'>"+role+"</a>");
	}
	else
	{
		$(".btn-role-play").html(role);
	}
</script> -->

<span class="btn-role-play">

</span>

<?php
	/* if($ac == "TESTING")
	{
		echo "TRUE : $ac";	
	}
	else
	{
		echo "FALSE : $role";	
	}
	//echo "done";
	var_dump($ac == "TESTING");*/
?>
<?php /* if($edit_form == 1) */ //echo "done"; ?> 


<?php
	//$this->db2 = $this->load->database(DB2_GROUP,TRUE);
	//echo $ss = "select * from perusahaan where id_perusahaan = '$edit_form' ";
	$bb = $this->db->query("select * from perusahaan where id_perusahaan = '$edit_form' ");
	$f = $bb->row();
?>

<?php //echo "<pre>";var_dump($bb);echo "<pre>"; ?>

<?php //var_dump($ac); ?>



<?php //var_dump($edit_form); ?>

<?php //echo $f['activation_code']; ?>

	