<?PHP
include ("../../conection/MySql.php");
	$quiz_id = $_POST['quiz_id'];
	$SqlSelectQuiz = mysql_query("SELECT * FROM quiz where AutoId = '$quiz_id' ") or die (mysql_error());
	$SqlType = mysql_query("SELECT * FROM type ") or die (mysql_error());
	$DadosQuiz = mysql_fetch_array($SqlSelectQuiz);
	$SqlQuestions = mysql_query("SELECT * FROM question where quiz_id = '$quiz_id' AND status = 'A' order by AutoId desc") or die (mysql_error());
	
	$LineQtd = mysql_num_rows($SqlQuestions);
?>

 <div class="container">
    <button type="button" name="button" class="titulo btn btn-success" data-toggle="modal" data-placement="top"  data-target="#ModalRegister">Cadastrar pergunta</button>
 </div>

 <div class="container">
   <h4 class="titulo">Dados do quiz</h4>
   <div class="card">
     <div class="card-body">
       <div class="form-group">
         <div class="col-md-12">
            <label>
              <strong> Nome: </strong> <?= $DadosQuiz['name']; ?>
            </label>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            <label>
               <strong>Descrição: </strong> <?= $DadosQuiz['description']; ?>
            </label>
          </div>
        </div>
      </div>
    </div>
  </div>
<br>

<?PHP if ($LineQtd != ''){ ?>
  <div class="container">
    <h4 class="titulo">Perguntas</h4>
  <?PHP
  $cont= 1;
    while ($LineQuestions = mysql_fetch_array($SqlQuestions)){
      $options = $LineQuestions['AutoId'];
      $SqlAnswers = mysql_query("SELECT * FROM answers WHERE question_id = '$options' AND status = 'A'");
   ?>
     <div class="card">
        <div class="card-body">
            <div id="quiz1" class="fadeIn"  data-wow-duration="1s" data-wow-delay=".3s">
              <div class="col-md-1">
                <button title="Excluir" type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#ModalDelete" data-autoid="<?= $LineQuestions['AutoId'] ?>" data-name="<?= $LineQuestions['subject'] ?>" ><i class="fa fa-trash-o"></i></button>
              </div>
              <div class="card-body">
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
          </div>
        </div>
      <br>
  <?PHP } ?>
</div>
<?PHP } ?>


<!-- Modal Register Question and Answers -->
  <div class="modal fade" id="ModalRegister" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <h4 id="myModalLabel">Cadastrar Pergunta</h4>
       </div>
         <form id="FormQuestion" action="" method="post">
         <input type="hidden" name="quiz_id" value="<?= $DadosQuiz['AutoId']; ?>">
         <div class="modal-body">
           <div class="form-horizontal">
               <div class="form-group">
                   <div class="col-md-12">
                     Pergunta
                     <input type="text" name="nameQuestion" id="nameQuestion" required class="form-control">
                   </div>
               </div>

             <div class="form-group">
               <div class="col-md-12">
                 Tipo
                 <select class="form-control" name="type" id="type" required>
                    <option value="">Selecione...</option>
                    <?PHP while($DadosType = mysql_fetch_array($SqlType)) {  ?>
                     <option value="<?= $DadosType['AutoId'] ?>"><?= $DadosType['name'] ?></option>
                     <?PHP } ?>
                   </select>
                 </div>
             </div>
           </div>
           <h5>Opções</h5>
             <div id="form">
               <div class="form-row">
                 <div class="form-group col-md-5">
                   Descrição
                     <input type="text" class="form-control" name="option[]" required>
                 </div>
                 <div class="form-group col-md-5">
                   Resposta Correta
                   <select class="form-control" name="right_answer[]" id="right_answer">
                     <option value="0">Não</option>
                     <option value="1">Sim</option>
                   </select>
                 </div>
                 <div class="form-group col-md-2">
                   Adicionar
                   <a class="btn btn-primary" href="#" data-id="1" id="btnAdd"><i class="fa fa-plus-circle"></i></a>
                 </div>
               </div>
             </div>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal">Fechar </button>
           <input type="button" value="Salvar" class="btn btn-success" id="BtnQuestion" />
         </div>
     </form>
     </div>
   </div>
  </div>
<!-- End Modal Register Question and Answers -->

<!-- Modal Delete -->
<div class="modal fade" id="ModalDelete" tabindex="-1" role="dialog" aria-labelledby="ModalDeleteLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="ModalDeleteLabel">Excluir Pergunta</h4>
      </div>
      <div class="modal-body">
        <form method="POST" action="" id="FormDelete" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="form-horizontal">
                  <div class="form-group">
                      <div class="col-md-12">
                        Deseja realmente excluir a pergunta:
                      </div>
                      <div class="col-md-12">
                        <div class="message"></div>
                      </div>
                  </div>
                </div>
            </div>
                <input name="AutoIdQuestion" type="hidden" class="form-control" id="AutoIdQuestion" value="">
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Fechar </button>
              <input type="button" value="Excluir" class="btn btn-danger" id="BtnDelete" />
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- End Modal Delete -->

<script src="http://code.jquery.com/jquery-1.8.2.min.js" type="text/javascript" ></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript">
$(function () {
    var divContent = $('#form');
    var botaoAdicionar = $('a[data-id="1"]');
    var i = 1;

    //Add option field
    $(botaoAdicionar).click(function () {
        $('<div class="contentInd"><div class="form-row"><div class="form-group col-md-5"><input type="text" class="form-control" name="option[]"></div><div class="form-group col-md-5"><select class="form-control" name="right_answer[]" id="right_answer"><option value="0">Não</option><option value="1">Sim</option></select></div><div class="form-group col-md-2"><a href="#" class="btn btn-danger linkRemover"> <i class="fa fa-trash-o"></i> </a></div></div></div><div class="clearfix"> </div>').appendTo(divContent);
        $('#removehidden').remove();
        i++;
        $('<input type="hidden" name="qtdFields" value="' + i + '" id="removehidden">').appendTo(divContent);
    });

    //Delete option field
    $('#form').on('click', '.linkRemover', function () {
        $(this).parents('.contentInd').remove();
        i--;
    });
});

	// Ajax Register
    $(document).ready(function() {
        $('#BtnQuestion').click(function() {

            var dados = $('#FormQuestion').serialize();

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: 'ajax/register_questions.php',
                async: true,
                data: dados,
                success: function(response) {
                    location.reload();
                }
            });
            return false;
        });

		// Ajax Delete

        $('#BtnDelete').click(function() {

            var dados = $('#FormDelete').serialize();

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: 'ajax/delete_questions.php',
                async: true,
                data: dados,
                success: function(response) {
                    location.reload();
                }
            });
            return false;
        });
    });

    //Modal delete
    $('#ModalDelete').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('autoid')
      var recipientnome = button.data('name')

      var modal = $(this)
      modal.find('.modal-title').text('Excluindo pergunta ')
      modal.find('#AutoIdQuestion').val(recipient)
      modal.find('.message').text(recipientnome)

    });
</script>
