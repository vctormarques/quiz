<?php
	include ("../../../conection/MySql.php");

	$AutoIdUser = $_POST['AutoIdUser'];
	$pass = $_POST['pass'];

		$SqlUpdate = mysql_query("UPDATE users SET password = md5('$pass'), updated_at = sysdate() where AutoId = '$AutoIdUser'") or die (mysql_error());
	
	$response = array("success" => true);
	echo json_encode($response);

?>
