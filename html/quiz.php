<?PHP
include ("../conection/MySql.php");
$name_quiz = $_POST['name_quiz'];
$quiz_id = $_POST['quiz_id'];
$SqlQuestions = mysql_query("SELECT * FROM question where quiz_id = '$quiz_id' AND status = 'A'") or die (mysql_error());

$start_date = date('Y-m-d H:i:s');
?>
<div class="container">
    <center><h4 class="titulo"><?= $name_quiz ?></h4></center>
      <form action="index.php?class=R_dados" method="post">
          <input type="hidden" name="quiz_id" value="<?= $quiz_id ?>">
          <input type="hidden" name="start_date" value="<?= $start_date ?>">
          <input type="hidden" name="name_quiz" value="<?= $name_quiz ?>">
          
<?PHP
 $cont = 1;
 $cont1 = 1;
 while ($LinhaQuestions = mysql_fetch_array($SqlQuestions)){
 $options = $LinhaQuestions['AutoId'];
 $SqlAnswers = mysql_query("SELECT * FROM answers WHERE question_id = '$options' AND status = 'A'");
   ?>

		<input type="hidden" name="question[]" value="<?= $LinhaQuestions['subject'] ?>">
		<input type="hidden" name="type[]" value="<?= $LinhaQuestions['type'] ?>">
          <div id="quiz1" class="card fadeIn section"  data-wow-duration="1s" data-wow-delay=".3s">
            <div class="card-body section-item">
              <h5 align="center"><?= $LinhaQuestions['subject'] ?></h5>
              <br>
              <div class="form-group row" align="center">
                <?PHP if ($LinhaQuestions['type'] == '1'){ 				
					while ($LinhaOption = mysql_fetch_array($SqlAnswers)) { ?>
                <div class="custom-control custom-radio  col-sm-4 col-form-label">					
                  <input type="radio" class="custom-control-input" id="<?= $LinhaOption['AutoId']?>" value="<?= $LinhaOption['AutoId']?>-<?= $options ?>" name="RB<?= $cont ?>" required >
                  <label class="custom-control-label" for="<?= $LinhaOption['AutoId']?>"style="cursor:pointer;" ><?= $LinhaOption['description']?></label>
                </div>
            <?PHP            
			  }
			   $cont++; 
			  } else {
					while ($LinhaOption = mysql_fetch_array($SqlAnswers)) { ?>
                <div class="custom-control custom-checkbox  col-sm-4 col-form-label">                  
                  <input type="checkbox" class="custom-control-input" id="<?= $LinhaOption['AutoId']?>" value="<?= $LinhaOption['AutoId']?>-<?= $options ?>" name="CB[]" >
                  <label class="custom-control-label" for="<?= $LinhaOption['AutoId']?>"style="cursor:pointer;" ><?= $LinhaOption['description']?></label>
                </div>
              <?PHP }
			  $cont1++;} ?>
              </div>
            </div>
          </div>
<?PHP } ?>
          <div class="col-md-12 fadeIn" align="center"  data-wow-duration="1s" data-wow-delay=".3s">
            <button type="submit" class="btn btn-success section-btn" name="Submit">Finalizar</button>
          </div>
        </form>
</div>
