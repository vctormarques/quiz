<?php
	include ("../../../conection/MySql.php");
	$AutoIdUser = $_POST['AutoIdUser'];
		$SqlDelete = mysql_query("UPDATE users SET status = 'E', updated_at = sysdate() where AutoId = '$AutoIdUser'") or die (mysql_error());
	$response = array("success" => true);
	echo json_encode($response);
?>
