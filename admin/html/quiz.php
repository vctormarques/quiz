<?PHP
include ("../../conection/MySql.php");
	$name_quiz = $_POST['name_quiz'];
	$quiz_id = $_POST['quiz_id'];
	$SqlQuestions = mysql_query("SELECT * FROM question where quiz_id = '$quiz_id' AND status = 'A'") or die (mysql_error());
?>

<div class="container">
  <h4 class="titulo">Visualizando o quiz: <?= $name_quiz ?></h4><br>
<?PHP
	$cont= 1;
	while ($LineQuestions = mysql_fetch_array($SqlQuestions)){
	$options = $LineQuestions['AutoId'];
	$SqlAnswers = mysql_query("SELECT * FROM answers WHERE question_id = '$options'");
?>

		  <div class="card fadeIn section"  data-wow-duration="1s" data-wow-delay=".3s">
			<div class="card-body section-item">
			  <h5 align="center"><?= $LineQuestions['subject'] ?></h5>
			  <br>
			  <div class="form-group row" align="center">
				<?PHP 
					if ($LineQuestions['type'] == '1'){ 
					while ($LinhaOption = mysql_fetch_array($SqlAnswers)) { 
				?>
				<div class="custom-control custom-radio  col-sm-4 col-form-label">					
				  <input type="radio" class="custom-control-input" id="<?= $LinhaOption['AutoId']?>" value="<?= $LinhaOption['AutoId']?>-<?= $options ?>" name="RB<?= $cont ?>" required >
				  <label class="custom-control-label" for="<?= $LinhaOption['AutoId']?>"style="cursor:pointer;" ><?= $LinhaOption['description']?></label>
				</div>
				<?PHP             
					} $cont++; 
				} else {
					while ($LinhaOption = mysql_fetch_array($SqlAnswers)) { 
				?>                
				<div class="custom-control custom-checkbox  col-sm-4 col-form-label">                  
				  <input type="checkbox" class="custom-control-input" id="<?= $LinhaOption['AutoId']?>" value="<?= $LinhaOption['AutoId']?>-<?= $options ?>" name="CB[]" >
				  <label class="custom-control-label" for="<?= $LinhaOption['AutoId']?>"style="cursor:pointer;" ><?= $LinhaOption['description']?></label>
				</div>
				<?PHP
						}
					}
				?>
			  </div>
			</div>
		  </div>
<?PHP } ?>
</div>
