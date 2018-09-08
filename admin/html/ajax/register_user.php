<?php
	include ("../../../conection/MySql.php");

	$login = $_POST['login'];
	$pass = $_POST['pass'];

		$sql = mysql_query("INSERT INTO `users` (`login`, `password`, created_at) VALUES ('$login', md5('$pass'), sysdate())");

	$response = array("success" => true);
	echo json_encode($response);

?>
