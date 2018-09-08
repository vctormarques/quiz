<?PHP 

include ("../../conection/MySql.php");

	$AutoIdQuizUser = $_POST['AutoIdQuizUser'];
	
	$SqlResult = mysql_query("
	SELECT *, case WHEN RespostaUser = AutoIdRespostaCerta  THEN 'certo' ELSE 'Errado' END AS parecer 
		FROM 
			(SELECT distinct
				Q.subject AS Pergunta, GROUP_CONCAT(DISTINCT AU.answers ORDER BY  AU.answers, '') AS RespostaUser, 
					GROUP_CONCAT(DISTINCT A.right_answer ORDER BY A.AutoId, '') AS right_answer,
					GROUP_CONCAT(DISTINCT A.description ORDER BY A.AutoId, '')  AS OpcaoUser,
					GROUP_CONCAT(DISTINCT AN.AutoId ORDER BY AN.AutoId, '') AS AutoIdRespostaCerta,
					GROUP_CONCAT(DISTINCT AN.description ORDER BY AN.AutoId, '') AS Opcao
			FROM question Q
				INNER JOIN user_quiz UQ on UQ.quiz_id = Q.quiz_id 
				LEFT OUTER JOIN answers_user AU on AU.question_id = Q.AutoId AND AU.user_quiz_id = UQ.AutoId
				INNER JOIN answers A on A.AutoId = AU.answers
				LEFT OUTER JOIN answers AN on AN.question_id = Q.AutoId AND AN.right_answer = 1
				INNER JOIN access AC on AC.AutoId = AU.access_id
			WHERE Q.status = 'A' AND UQ.AutoId = '$AutoIdQuizUser' 
			GROUP BY Q.AutoId) AS A ") or die (mysql_error(). "Erro ao mostrar resposta");
?>

  <div class="container">
      <center><h4 class="titulo">Respostas do quiz</h4></center>
	  
<?PHP while($Result = mysql_fetch_array($SqlResult)) {  ?>

		<?PHP if ($Result['parecer'] == 'Errado') {?>
          <div id="quiz1" class="card fadeIn sectionWrong"  data-wow-duration="1s" data-wow-delay=".3s">
		<?PHP } else { ?>
          <div id="quiz1" class="card fadeIn sectionRight"  data-wow-duration="1s" data-wow-delay=".3s">		
		<?PHP } ?>
            <div class="card-body section-item">
              <h5 align="center"><?= $Result['Pergunta'] ?></h5>
              <br>
              <div class="form-group row" align="left">
                <div class="col-md-12">
                  <strong>Resposta Selecionada: </strong><?= $Result['OpcaoUser'] ?>
                </div>
                <div class="col-md-12">
                  <strong>Resposta Correta: </strong><?= $Result['Opcao'] ?>
                </div>

              </div>
            </div>
          </div>
	  <?PHP } ?>
      </div>
