<?PHP

ob_start("mb_output_handler");

//header("Content-Type: text/html; charset=ISO-8859-1",true);



ini_set('display_errors', true);

error_reporting(E_ALL);

$servidor = "trezoteam.mysql.dbaas.com.br";

$usuario = "trezoteam";

$banco = "trezoteam";

$senha = "vertrigo";

$link = mysql_connect($servidor,$usuario,$senha);

$db = mysql_select_db($banco, $link);

mysql_query("SET NAMES 'utf8'");

mysql_query('SET character_set_connection=utf8');

mysql_query('SET character_set_client=utf8');

mysql_query('SET character_set_results=utf8');

?>

