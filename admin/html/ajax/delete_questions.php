<?php
	include ("../../../conection/MySql.php");
	$AutoIdQuestion = $_POST['AutoIdQuestion'];
	$SqlSelectOption = mysql_query("SELECT * FROM answers where question_id = '$AutoIdQuestion'") or die (mysql_error());
	while ($OptionLine = mysql_fetch_array($SqlSelectOption)){
			$AutoIdAnswers = $OptionLine['AutoId'];
			$SqlDelete = mysql_query("UPDATE answers SET status = 'E' where AutoId = '$AutoIdAnswers'") or die (mysql_error());
	}

	$SqlDeleteQuestion = mysql_query("UPDATE question set status = 'E' where AutoId = '$AutoIdQuestion'") or die (mysql_error());

	$response = array("success" => true);
	echo json_encode($response);

?>
