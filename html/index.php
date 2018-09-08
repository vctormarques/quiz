<?PHP
session_start();
if((!isset ($_SESSION['IdUser']) == true) and (!isset ($_SESSION['name']) == true))
{
	unset($_SESSION['IdUser']);
	unset($_SESSION['name']);
	header('location:../index.php');
	}

	$IdUser = $_SESSION['IdUser'];
	$name = $_SESSION['name'];
	header('Cache-Control: no cache');
	session_cache_limiter('private_no_expire');
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../style.css">
  </head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php"><img src="../img/quiz.png" style="width:100px;"></img></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
      </ul>
      <form class="form-inline my-2 my-lg-0">
        <a class="btn btn-outline-success my-2 my-sm-0" href="index.php">Home <span class="sr-only">(current)</span></a>
      </form>
    </div>
  </nav>

<?PHP if ($_GET['class'] == ""){

	include ("../conection/MySql.php");
	include ("../script/selecioneQuiz.php");

	if ($qtdQuiz != ''){ 
?>

	<div class="container-fluid">
	  <center><h4 class="titulo">Escolha um quiz para iniciar</h4></center>
	  <div class="row titulo">
		<table class="table">
		  <thead>
			<tr>
			  <td align="center">Responder</td>
			  <td>Nome</td>
			  <td>Descrição</td>
			</tr>
		  </thead>
		  <tbody>
	<?PHP while ($LinhaQuiz = mysql_fetch_array($SqlQuiz)) { ?>
			<tr>
			  <td width="10%" align="center">
				<form action="index.php?class=Quiz" method="post" name="Responder">
				  <input type="hidden" name="quiz_id" value="<?PHP echo $LinhaQuiz['AutoId'] ?>">
				  <input type="hidden" name="name_quiz" value="<?PHP echo $LinhaQuiz['name'] ?>">
				  <button type="submit" class="btn btn-light btn-sm" name="Responder"><i class="fa fa-check-square-o" style="font-size:25px; cursor:pointer;"></i></button>
				</form>
			  </td>
			  <td><?PHP echo $LinhaQuiz['name'] ?></td>
			  <td><?PHP echo $LinhaQuiz['description'] ?></td>
			</tr>
	<?PHP } ?>
		  </tbody>
		</table>
	  </div>
	</div>

	<?PHP } else {
			echo "<h5 class='titulo'> Não possui nenhum quiz disponível no momento</h5>";
			} } else {

			if (isset($_GET['class']))
				$class=$_GET['class'];
			else
				$class="";
			switch ($class){
				
			case 'Quiz':
			include ("quiz.php");
			break;

			case 'R_dados':
			include ("dados.php");
			break;
			
			}

			}
	?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

</body>
</html>

