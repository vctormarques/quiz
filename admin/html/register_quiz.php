<?PHP
	include ("../../conection/MySql.php");
?>

<div class="container">
  <center><h4 class="titulo">Cadastrar quiz</h4></center>
  <form class="titulo" action="" method="post" name="Cadastrar">
    <div class="form-group">
      <div class="col-md-12">
        <input type="text" name="name" class="form-control" required placeholder="Nome">
      </div>
    </div>
    <div class="form-group">
      <div class="col-md-12">
        <textarea class="form-control" required rows="10" name="description" placeholder="Descrição"></textarea>
      </div>
    </div>
    <div class="col-md-12" align="right">
      <button type="submit" class="btn btn-success" name="Cadastrar">Salvar</button>
    </div>
  </form>
</div>

<?PHP if (isset($_POST['Cadastrar'])){
	
	include ("../../conection/MySql.php");
	$name = $_POST['name'];
	$description = $_POST['description'];

	$SqlInsertQuiz = mysql_query("INSERT INTO `quiz` (`name`, `description`, `created_at`) VALUES ('$name', '$description', sysdate())") or die (mysql_error());
	$IdQuiz = mysql_insert_id();
	
if ($SqlInsertQuiz){ ?>
	<form method='post' name="FromSubmit" action="index.php?class=C_Questions" id="idSubmit">
	  <input type="hidden" name="quiz_id" value="<?PHP echo $IdQuiz ?>">
		<div align="center">
			 <div class="uk-width-large-3-5" >
				<div class="md-card" id="login_card" >
					<div class="md-card-content large-padding" id="login_form" >
						<h5><font color="#F5781E">Cadastrando. . . </font></h5><br><img src="../../img/loading.gif" width="100px"></i><br>
					</div>
				</div>
			 </div>
		</div>
	</form>
 
 <script type="text/javascript">
	setTimeout(function(){
		$('#idSubmit').submit();
	}, 2000);
 </script>
 
<?PHP } else {
			echo "<center>Erro ao realizar cadastro</center>";
		}
	} ?>
	
<script src="http://code.jquery.com/jquery-1.8.2.min.js" type="text/javascript" ></script>
