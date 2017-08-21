<?php
if(!isset($_SESSION['reserva_sala_tipo_usuario'])){session_start();}
if($_SESSION['reserva_sala_tipo_usuario']>1){ exit("Somente Administrador tema acesso a esta pagína!");}
 if(isset($_POST['Cadastra_sala'])){	
 	$salas= new Salas;
 	$cadastrar=$salas->criar($_POST['nome']); 	
}
$pagegroup="salas";
$title='Cadastro de  Salas';
include_once("template/header.php");?>
<h1 class="title"><?php echo $title ?></h1>

<?php 
if(isset($_SESSION['msg']['error']) and $_SESSION['msg']['error']): ?>
<div class="alert alert-danger"><a data-dismiss="alert" class="close">×</a>
<?php echo $_SESSION['msg']['error']['main']; ?></div>
<?php endif;?>
<?php if(isset($_SESSION['msg']['sucesso'])): ?>
<div class="alert alert-success">
<a data-dismiss="alert" class="close">×</a><?php echo $_SESSION['msg']['sucesso']; ?></div>
<?php endif;?>
<form id="salas_form_cadastro" action="" method="post">
	<p><label for="nome">Nome da sala</label><br><input id="nome" type="text" name="nome" value="<?php echo (isset($_POST['nome'])) ? $_POST['nome'] : "" ; ?>">

	<?php if(isset($_SESSION['msg']['error']['nome'])): ?>
		<br><span class="error"><?php echo $_SESSION['msg']['error']['nome'];?> </span>
	<?php endif;?>	
	</p>	
	<p><input class="btn btn-primary" type="submit" name="Cadastra_sala" value="Enviar"></p>
</form>

<a class="btn btn-link" href="<?php echo BASE_URL ?>"> <span class="glyphicon glyphicon-arrow-left" ></span> Voltar</a>

<?php 
unset($_SESSION['msg']);
include_once("template/footer.php");?>