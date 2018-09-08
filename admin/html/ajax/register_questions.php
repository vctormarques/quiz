<?php
	include ("../../../conection/MySql.php");

	$quiz_id = $_POST['quiz_id'];
	$nameQuestion = $_POST['nameQuestion'];
	$type = $_POST['type'];
	$right_answer = $_POST['right_answer'];

	$sql = mysql_query("INSERT INTO `question` (`subject`, `quiz_id`, type, created_at) VALUES ('$nameQuestion', '$quiz_id', '$type', sysdate())");
	$IdQuestion = mysql_insert_id();

	$option=$_POST['option'];
	$qtd = count($option);

	$right_answer = $_POST['right_answer'];
	for($i=0; $i<$qtd; $i++){
		$SqlInserAnswers = mysql_query("INSERT INTO `answers` (`question_id`, `description`, right_answer) VALUES ('$IdQuestion', '$option[$i]', '$right_answer[$i]')");
	}

	$response = array("success" => true);
	echo json_encode($response);
?>
