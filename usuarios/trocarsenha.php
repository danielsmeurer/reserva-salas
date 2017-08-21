<?php
$uri = $_SERVER ['REQUEST_URI'];
$uri = explode('trocarsenha.php',$uri);
$id= str_replace('/','', $uri[1]);
if(!is_numeric($id))die("Acesso não Autorizado!");
$pagegroup="usuarios";
$title='Trocar Senha';
include_once('../loader.php');
include_once FILES_BASE_ADDRESS."/template/header.php";
if(($_SESSION['reserva_sala_tipo_usuario']>1) and ($idlogado!=$id) )die("Você não tem permissão para editar este perfil!");

$usuarios = new Usuarios;

if(isset($_POST) and !empty($_POST)){
	
	$usuarios->trocar_senha($id,$_POST['senha'], $_POST['conf_senha']);	
}
var_dump($_POST);
?>

<h1 class="title"> <?php echo $title; ?></h1>

<?php if(isset($_SESSION['msg']['error']) and $_SESSION['msg']['error']): ?>
<div class="alert alert-danger"><a data-dismiss="alert" class="close">×</a>
<?php echo $_SESSION['msg']['error']['main']; ?></div>
<?php endif;?>
<?php if(isset($_SESSION['msg']['sucesso'])): ?>
<div class="alert alert-success">
<a data-dismiss="alert" class="close">×</a><?php echo $_SESSION['msg']['sucesso']; ?></div>
<?php endif;?>
<form id="usuario_form_cadastro" action="" method="post">
<p><label for="senha">Senha</label><br>	<input id="senha" type="password" name="senha" value="<?php echo (isset($_POST['senha'])) ? $_POST['senha'] : "" ; ?>">
	<?php if(isset($_SESSION['msg']['error']['senha'])): ?>
		<br><span class="error"><?php echo $_SESSION['msg']['error']['senha'];?> </span>
	<?php endif;?>	
	</p>
	<p><label for="conf_senha">Confirmação de senha</label><br>	<input id="conf_senha" type="password" name="conf_senha" value="<?php echo (isset($_POST['conf_senha'])) ? $_POST['conf_senha'] : "" ; ?>">
	<?php if(isset($_SESSION['msg']['erro']['conf_senha'])): ?>
		<br><span class="error"><?php echo $_SESSION['msg']['error']['conf_senha'];?> </span>
	<?php endif;?>	
	</p>

	<p><input class="btn btn-primary" type="submit" name="Cadastra_usuario" value="Enviar"></p>
</form>

<a class="btn btn-link" href="<?php echo BASE_URL ?>"> <span class="glyphicon glyphicon-arrow-left" ></span> Voltar</a>
<?php unset($_SESSION['msg']); ?>