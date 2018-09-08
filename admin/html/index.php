<?PHP 
session_start();
if((!isset ($_SESSION['login']) == true) and (!isset ($_SESSION['pass']) == true))
{
	unset($_SESSION['login']);
	unset($_SESSION['pass']);
	header('location:../index.php');
	}
	
	$login = $_SESSION['login'];
	
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
    <link rel="stylesheet" href="../../style.css">
  </head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php"><img src="../../img/quiz.png" style="width:100px;"></img></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
      </ul>

      <div class="col-md-1" align="center">
        <a class="btn btn-outline-success my-2 my-sm-0 " href="index.php">Principal</a>
      </div>
      <div class="col-md-1" align="center">
        <a class="btn btn-outline-success my-2 my-sm-0" href="index.php?class=C_Quiz">Cadastrar</a>
      </div>
	  <div class="col-md-1" align="center">
		<a class="btn btn-outline-success my-2 my-sm-0" href="index.php?class=Rel">Relatórios</a>
	  </div>       
	  <div class="col-md-1" align="center">
        <a class="btn btn-outline-success my-2 my-sm-0" href="index.php?class=User">Usuários</a>
      </div>
    </div>
  </nav>

<?PHP if ($_GET['class'] == ""){

include ("../../conection/MySql.php");
include ("../../script/selecioneQuizAdmin.php");

	if ($LineQuiz != ''){
?>

<div class="container-fluid">
  <center><h4 class="titulo">Todos os quiz</h4></center>
  <div class="row titulo">
    <table class="table">
      <thead>
        <tr>
          <td align="center">Visualizar</td>
          <td>Nome</td>
          <td>Descrição</td>
        </tr>
      </thead>
      <tbody>
<?PHP while ($LineQuiz = mysql_fetch_array($SqlQuiz)) { ?>
        <tr>
          <td width="10%" align="center">
            <form action="index.php?class=Quiz" method="post" name="View">
              <input type="hidden" name="quiz_id" value="<?PHP echo $LineQuiz['AutoId'] ?>">
              <input type="hidden" name="name_quiz" value="<?PHP echo $LineQuiz['name'] ?>">
              <button type="submit" class="btn btn-secondary btn-sm" name="View"><i class="fa fa-ellipsis-h" style="font-size:25px; cursor:pointer;"></i></button>
            </form>
          </td>
          <td><?PHP echo $LineQuiz['name'] ?></td>
          <td><?PHP echo $LineQuiz['description'] ?></td>
        </tr>
<?PHP } ?>
      </tbody>
    </table>
  </div>
</div>

<?PHP } else {
			echo "<h5 class='titulo'> Não foi encontrado nenhum quiz</h5>";
		} 
		} else {

			if (isset($_GET['class']))
				$class=$_GET['class'];

			else
				$class="";
			switch ($class){

			case 'Quiz':
			include ("quiz.php");
			break;

			case 'C_Quiz':
			include ("register_quiz.php");
			break;

			case 'C_Questions':
			include ("register_questions.php");
			break;

			case 'User':
			include ("users.php");
			break;

			case 'Rel':
			include ("report.php");
			break;

			case 'V_Quiz':
			include ("view_quiz.php");
			break;

			}
			}?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

</body>
</html>

