<?PHP
include ("../../conection/MySql.php");
	$SqlUser = mysql_query("SELECT * FROM users WHERE status = 'A'") or die (mysql_error());
?>

<div class="container-fluid">
	<center>
		<h4 class="titulo">Usuários</h4>
	</center>
		<button type="button" name="RegisterUser" class="titulo btn btn-success" data-toggle="modal" data-placement="top"  data-target="#ModalRegister">Cadastrar usuário</button>	
	
		<div class="row titulo">
			<table class="table">
			  <thead>
				<tr>
				  <td align="center">Inativar</td>
				  <td align="center">Alterar senha</td>			  
				  <td>Login</td>
				</tr>
			  </thead>
			  <tbody>
	<?PHP while ($LineUser = mysql_fetch_array($SqlUser)){?>
				<tr>
					<td width="15%" align="center"><button title="Inativar" type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#ModalDelete" data-autoid="<?= $LineUser['AutoId'] ?>" data-name="<?= $LineUser['login'] ?>" ><i class="fa fa-trash-o"></i></button></td>				
					<td width="15%" align="center"><button title="Alterar Senha" type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#ModalEditPass" data-autoid="<?= $LineUser['AutoId'] ?>" data-name="<?= $LineUser['login'] ?>" ><i class="fa fa-lock"></i></button></td>				
					<td><?= $LineUser['login'] ?></td>				
				</tr>

	<?PHP	} 	?>
				</tbody>
			</table>
		</div>
	
			<!-- Modal Register User -->
			  <div class="modal fade" id="ModalRegister" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			   <div class="modal-dialog">
				 <div class="modal-content">
					<div class="modal-header">
					 <h4 id="myModalLabel">Cadastrar Usuário</h4>
					</div>
					 <form id="FormRegister" action="" method="post">
					 
						 <div class="modal-body">
						   <div class="form-horizontal">
							   <div class="form-group">
								   <div class="col-md-12">
									 Login
									 <input type="text" name="login" id="login" required class="form-control">
								   </div>
							   </div>

							 <div class="form-group">
							   <div class="col-md-12">
								 Senha
								 <input type="text" name="pass" id="pass" required class="form-control">
								 </div>
							 </div>
						   </div>					  
						 </div>
						 
						 <div class="modal-footer">
						   <button type="button" class="btn btn-default" data-dismiss="modal">Fechar </button>
						   <input type="button" value="Salvar" class="btn btn-success" id="BtnRegister" />
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
						<h4 class="modal-title" id="ModalDeleteLabel">Excluir Usuário</h4>
					  </div>
					  <div class="modal-body">
						<form method="POST" action="" id="FormDelete" enctype="multipart/form-data">
							<div class="modal-body">
							  <div class="form-horizontal">
								  <div class="form-group">
									  <div class="col-md-12">
										Deseja realmente excluir o usuário: <strong><span class="message"></span></strong> ?
									  </div>
								  </div>
								</div>
							</div>
								<input name="AutoIdUser" type="hidden" class="form-control" id="AutoIdUser" value="">
							<div class="modal-footer">
							  <button type="button" class="btn btn-default" data-dismiss="modal">Fechar </button>
							  <input type="button" value="Inativar" class="btn btn-danger" id="BtnDelete" />
							</div>
						</form>
					  </div>
					</div>
				  </div>
				</div>
			<!-- End Modal Delete -->
			
			<!-- Modal Update Pass -->
				<div class="modal fade" id="ModalEditPass" tabindex="-1" role="dialog" aria-labelledby="ModalDeleteLabel">
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<h4 class="modal-title" id="ModalDeleteLabel">Excluir Usuário</h4>
					  </div>
					  <div class="modal-body">
						<form method="POST" action="" id="FormUpdate" enctype="multipart/form-data">
							<div class="modal-body">
							  <div class="form-horizontal">
								  <div class="form-group">
									  <div class="col-md-12">
										Alterando a senha do <strong><span class="message"></span></strong>.										
									  </div>
									  <div class="col-md-12"><br>
										<input type="text" name="pass" id="pass" class="form-control" placeholder="Digite a nova senha">
									  </div>
								  </div>
								</div>
							</div>
								<input name="AutoIdUser" type="hidden" class="form-control" id="AutoIdUser" value="">
							<div class="modal-footer">
							  <button type="button" class="btn btn-default" data-dismiss="modal">Fechar </button>
							  <input type="button" value="Alterar Senha" class="btn btn-danger" id="BtnUpdate" />
							</div>
						</form>
					  </div>
					</div>
				  </div>
				</div>
			<!-- End Modal Delete -->
</div>
<script src="http://code.jquery.com/jquery-1.8.2.min.js" type="text/javascript" ></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript">

// Ajax Register
    $(document).ready(function() {
        $('#BtnRegister').click(function() {

            var dados = $('#FormRegister').serialize();

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: 'ajax/register_user.php',
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
                url: 'ajax/delete_user.php',
                async: true,
                data: dados,
                success: function(response) {
                    location.reload();
                }
            });
            return false;
        });
		
		// Ajax Update Pass
        $('#BtnUpdate').click(function() {

            var dados = $('#FormUpdate').serialize();

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: 'ajax/update_user.php',
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
      modal.find('.modal-title').text('Excluindo usuário')
      modal.find('#AutoIdUser').val(recipient)
      modal.find('.message').text(recipientnome)

    });
	
    //Modal update
    $('#ModalEditPass').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('autoid')
      var recipientnome = button.data('name')

      var modal = $(this)
      modal.find('.modal-title').text('Alterando a senha')
      modal.find('#AutoIdUser').val(recipient)
      modal.find('.message').text(recipientnome)

    });
</script>
