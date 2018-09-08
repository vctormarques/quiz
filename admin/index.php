<!DOCTYPE html>
<html lang="en">
<head>
	<title>Quiz Trezo</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="../login/images/icons/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="../login/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../login/vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="../login/vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="../login/vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="../login/css/util.css">
	<link rel="stylesheet" type="text/css" href="../login/css/main.css">
</head>
<style>
	#message{
		display: none;
		color: red;
		font-size: 15px;
	}
</style>

<body>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="../img/quiz.png" alt="IMG">
				</div>

				<form class="login100-form validate-form" autocomplete="off" name="submitLogin" method="post" action="">
					<span class="login100-form-title">
						Dados para acesso<br>
						<span id="message">
							Erro ao efetuar login, verifique o usuário e senha.
						</span>
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Campo obrigatório: Nome inválido">
						<input class="input100" type="text" name="login" placeholder="Login">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Campo obrigatório: Senha inválido">
						<input class="input100" type="password" name="password" placeholder="Senha">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit" name="submitLogin">
							Entrar
						</button>
					</div>

				</form>
			</div>
		</div>
	</div>

<?PHP if(isset($_POST['submitLogin'])){

	include ("../conection/MySql.php");
	session_start();

	$login =  $_POST['login'];
	$pass =  $_POST['password'];
	$InsertAccess = mysql_query("SELECT * FROM users WHERE login = '$login' AND password = md5('$pass') AND status = 'A'") or die (mysql_error());
	$Sql = mysql_num_rows($InsertAccess);
	
	if ($Sql == '1'){
		$_SESSION['login'] = $login;
		$_SESSION['pass'] =  $pass;
		header('location:html/index.php');
	} else {
		echo "
			<style> 
				#message { 
					display:block;
				}				
			</style>";
		}

	}?>


	<script src="../login/vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="../login/vendor/bootstrap/js/popper.js"></script>
	<script src="../login/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="../login/vendor/select2/select2.min.js"></script>
	<script src="../login/vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
	<script src="../login/js/main.js"></script>

</body>
</html>

