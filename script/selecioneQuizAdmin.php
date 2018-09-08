<?php
$SqlQuiz = mysql_query("SELECT * FROM quiz ") or die (mysql_error());
$LineQuiz = mysql_num_rows($SqlQuiz);

 ?>
