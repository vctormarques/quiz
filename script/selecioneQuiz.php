<?php
$SqlQuiz = mysql_query("SELECT * FROM quiz where status = 'A'") or die (mysql_error());
$qtdQuiz = mysql_num_rows($SqlQuiz);
 ?>
