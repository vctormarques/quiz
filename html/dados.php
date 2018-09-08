<?PHP
   if( $_SERVER['REQUEST_METHOD']=='POST' )
   {
		   $request = md5( implode( $_POST ) );
		   if( isset( $_SESSION['last_request'] ) && ($_SESSION['last_request'] == $request) )
		   {
			echo "Questionário já respondido";
			exit();
			}
		   else
		   {
			   $_SESSION['last_request']  = $request;


include ("../conection/MySql.php");
		$quiz_id = $_POST['quiz_id'];
		$name_quiz = $_POST['name_quiz'];
		$start_date = $_POST['start_date'];
		$question = $_POST['question'];
		$type = $_POST['type'];
		$qtdQuestion = count($question);
		$end_date = date('Y-m-d H:i:s');

$cont = 1;
	$SqlInsertQuizUser = mysql_query("INSERT INTO user_quiz (quiz_id, access_id, start_date, end_date) VALUES ('$quiz_id', '$IdUser', '$start_date', '$end_date')") or die (mysql_error()."Erro ao inserir Quiz User");
	$IdQuizUser = mysql_insert_id();
		foreach($_POST["CB"] as $optionF) {
		
			$explodeCB = explode('-', $optionF);
			$option = $explodeCB[0];
			$questionAnswers = $explodeCB[1];      
			$SqlInsertAnswers = mysql_query("INSERT INTO `answers_user` (`question_id`, `answers`,start_date, end_date, access_id, user_quiz_id) VALUES ('$questionAnswers', '$option', '$start_date', '$end_date','$IdUser', '$IdQuizUser')") or die (mysql_error(). "Erro ao inserir Answers Tipo 2");
		}
		
		for ($i=0; $i<$qtdQuestion; $i++){		
			if ($type[$i] == '1'){
				$variavel = 'RB'.$cont;
				$answers = $_POST[$variavel];
				$explode = explode('-', $answers);
				$option = $explode[0];
				$questionAnswers = $explode[1];

					$SqlInsertAnswers = mysql_query("INSERT INTO `answers_user` (`question_id`, `answers`,start_date, end_date, access_id, user_quiz_id) VALUES ('$questionAnswers', '$option', '$start_date', '$end_date', '$IdUser', '$IdQuizUser')") or die (mysql_error(). "Erro ao inserir Answers Tipo 1");
			$cont++;
			}

		}



if ($SqlInsertAnswers){

$SqlResult = mysql_query("
	SELECT *, case WHEN RespostaUser = AutoIdRespostaCerta  THEN 'certo' ELSE 'Errado' END AS parecer 
		FROM 
			(SELECT DISTINCT
				Q.subject AS Pergunta, GROUP_CONCAT(DISTINCT AU.answers order by AU.answers, '') AS RespostaUser, 
					GROUP_CONCAT(DISTINCT A.right_answer ORDER BY A.AutoId, '') AS right_answer,
					GROUP_CONCAT(DISTINCT A.description ORDER BY A.AutoId, '')  AS OpcaoUser,
					GROUP_CONCAT(DISTINCT AN.AutoId order by AN.AutoId, '') AS AutoIdRespostaCerta,
					GROUP_CONCAT(DISTINCT AN.description ORDER BY AN.AutoId, '') AS Opcao
			FROM question Q
				INNER JOIN user_quiz UQ on UQ.quiz_id = Q.quiz_id AND UQ.AutoId = (SELECT MAX(autoid) FROM user_quiz WHERE user_quiz.quiz_id = Q.quiz_id)
				LEFT OUTER JOIN answers_user AU on AU.question_id = Q.autoid AND AU.user_quiz_id = UQ.AutoId
				INNER JOIN answers A on A.AutoId = AU.answers
				LEFT OUTER JOIN answers AN on AN.question_id = Q.AutoId AND AN.right_answer = 1
				INNER JOIN access AC on AC.AutoId = AU.access_id
				
			WHERE Q.status = 'A' AND Q.quiz_id = '$quiz_id' 
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
<?PHP } else {
			echo "Acontece um erro ao verificar as respostas";
		}
		}
		}
?>
