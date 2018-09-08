<?PHP 
	include ("../../conection/MySql.php");
	
	$SqlQuiz = mysql_query("
		SELECT name, start_date, end_date, AutoId, SUM(qtdRight) qtdRight, SUM(qtdWrong) qtdWrong, SUM(qtdRight) + SUM(qtdWrong) qteTotal, nameQuiz, AutoIdQuizUser,
			(SUM(qtdRight) /  (SUM(qtdRight) + SUM(qtdWrong)))*100  percentage 
				FROM
					(SELECT name,  start_date, end_date, AutoId, nameQuiz, AutoIdQuizUser,
					(SELECT count(*) FROM user_quiz WHERE user_quiz.AutoId = A.AutoId and A.respostaUser = A.AutoIdRespostaCerta) AS qtdRight,
					(SELECT count(*) FROM user_quiz WHERE user_quiz.AutoId = A.AutoId and A.respostaUser <> A.AutoIdRespostaCerta) AS qtdWrong
						FROM
		(SELECT distinct
				Q.subject AS Pergunta, UQ.AutoId, QUIZ.name AS nameQuiz, UQ.AutoId AutoIdQuizUser,
					GROUP_CONCAT(DISTINCT AU.answers order by AU.answers, '') AS RespostaUser, 
					GROUP_CONCAT(DISTINCT A.right_answer order by A.AutoId, '') AS right_answer,
					GROUP_CONCAT(DISTINCT A.description order by A.AutoId, '')  AS OpcaoUser,
					GROUP_CONCAT(DISTINCT AN.AutoId order by AU.AutoId, '') AS AutoIdRespostaCerta,
					GROUP_CONCAT(DISTINCT AN.description order by AN.AutoId, '') AS Opcao,
                    DATE_FORMAT(UQ.start_date, '%d/%m/%Y %H:%i:%s') AS start_date, 
					DATE_FORMAT(UQ.end_date, '%d/%m/%Y %H:%i:%s') AS end_date,
                    AC.name
			FROM question Q
				INNER JOIN user_quiz UQ on UQ.quiz_id = Q.quiz_id 
				LEFT OUTER JOIN answers_user AU on AU.question_id = Q.AutoId AND AU.user_quiz_id = UQ.AutoId
				INNER JOIN answers A on A.AutoId = AU.answers
				LEFT OUTER JOIN answers AN on AN.question_id = Q.AutoId AND AN.right_answer = 1
				INNER JOIN access AC on AC.AutoId = AU.access_id		
                INNER JOIN quiz QUIZ on QUIZ.AutoId = Q.quiz_id
			WHERE Q.status = 'A' 
			GROUP BY Q.AutoId, UQ.AutoId) AS A) AS B
			GROUP BY name, start_date, end_date
	") or die (mysql_error(). "Ocorreu um erro ao buscar resultados do quiz");
?>
<div class="container-fluid">
  <center><h4 class="titulo">Resultados</h4></center>
  <div class="row titulo">
    <table class="table">
      <thead>
        <tr>
          <td align="center">Visualizar</td>
          <td>Quiz</td>
          <td>Pessoa</td>
          <td>Início</td>
          <td>Fim</td>
          <td>Erros</td>
          <td>Acertos</td>
          <td>Total</td>
          <td>%</td>
        </tr>
      </thead>
      <tbody>
<?PHP 
	while ($LineQuiz = mysql_fetch_array($SqlQuiz)){ 
?>	  
        <tr>
			<td width="10%" align="center">
				<form action="index.php?class=V_Quiz" method="post" name="View">
					<input type="hidden" name="AutoIdQuizUser" value="<?= $LineQuiz['AutoIdQuizUser'] ?>">
					<button type="submit" class="btn btn-secondary btn-sm" name="View"><i class="fa fa-ellipsis-h" style="font-size:25px; cursor:pointer;"></i></button>
				</form>
			</td>
			<td><?= $LineQuiz['nameQuiz']?></td>
			<td><?= $LineQuiz['name']?></td>
			<td><?= $LineQuiz['start_date']?></td>
			<td><?= $LineQuiz['end_date']?></td>
			<td><?= $LineQuiz['qtdWrong']?></td>
			<td><?= $LineQuiz['qtdRight']?></td>
			<td><?= $LineQuiz['qteTotal']?></td>
			<td width="30%">
				<div class="progress">
					<div class="progress-bar" role="progressbar" style="width: <?PHP echo $LineQuiz['percentage']?>%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
				</div><?PHP echo number_format($LineQuiz['percentage'], 2, '.', '')?>%
			</td>
		  </tr>
	<?PHP } ?>		  
      </tbody>
    </table>
  </div>
</div>
