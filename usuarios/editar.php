<?php
$uri = $_SERVER ['REQUEST_URI'];
$uri = explode('editar.php',$uri);
$id= str_replace('/','', $uri[1]);

if(!is_numeric($id))die("Acesso não Autorizado!");
$pagegroup="usuarios";
$title='Editar Usuário';
include_once('../loader.php');
include_once FILES_BASE_ADDRESS."/template/header.php";
if(($_SESSION['reserva_sala_tipo_usuario']>1) and ($idlogado!=$id) )die("Você não tem permissão para editar este perfil!");
$usuarios = new Usuarios;
$usuario=$usuarios->get_User_By_ID($id);
if(isset($_POST) and !empty($_POST)){
	$novos_dados= array('id_user'=> $id, 'nome'=>$_POST['nome'], 'email' => $_POST['email'],'email_atual'=>$usuario[0]['email']);
	$edita=$usuarios->editar_usuario($novos_dados);

	
}
?>
<?php echo (isset($admin))? "<div class='alert alert-info'><a data-dismiss='alert' class='close'>x</a>Cadastre o usuário administrador do sistema</div>":"";?>
<h1 class="title"><?php echo $title ?></h1>

<?php if(isset($_SESSION['msg']['error']) and $_SESSION['msg']['error']): ?>
<div class="alert alert-danger"><a data-dismiss="alert" class="close">×</a>
<?php echo $_SESSION['msg']['error']['main']; ?></div>
<?php endif;?>
<?php if(isset($_SESSION['msg']['sucesso'])): ?>
<div class="alert alert-success">
<a data-dismiss="alert" class="close">×</a><?php echo $_SESSION['msg']['sucesso']; ?></div>
<?php endif;?>
<form id="usuario_form_cadastro" action="" method="post">
	<p><label for="nome">Nome</label><br><input id="nome" type="text" name="nome" value="<?php echo (isset($usuario[0]['nome'])) ?$usuario[0]['nome'] : "" ; ?>">

	<?php if(isset($_SESSION['msg']['error']['nome'])): ?>
		<br><span class="error"><?php echo $_SESSION['msg']['error']['nome'];?> </span>
	<?php endif;?>	
	</p>
	<p><label for="email">E-mail</label><br><input id="email" type="email" name="email" value="<?php echo (isset($usuario[0]['email'])) ? $usuario[0]['email'] : "" ; ?>">
	<?php if(isset($_SESSION['msg']['error']['email'])): ?>
		<br><span class="error"><?php echo $_SESSION['msg']['error']['email'];?> </span>
	<?php endif;?>	
	</p>

	<p><label for="login">Login</label><br> <input readonly="true" class='readonly' type="text" name="login" value="<?php echo (isset($usuario[0]['login'])) ? $usuario[0]['login'] : "" ; ?>">
	<?php if(isset($_SESSION['msg']['error']['login'])): ?>
		<br><span class="error"><?php echo $_SESSION['msg']['error']['login'];?> </span>
	<?php endif;?>	
	</p>
	
		
	<p><input class="btn btn-primary" type="submit" name="Cadastra_usuario" value="Enviar"></p>
</form>
<br>
<a href="<?php echo BASE_URL;?>/usuarios/trocarsenha.php/<?php echo $id;?>">Trocar Senha</a>
<br>
<a class="btn btn-link" href="<?php echo BASE_URL;?>/usuarios/lista"> <span class="glyphicon glyphicon-arrow-left" ></span> Voltar</a>

<?php 
unset($_SESSION['msg']);
include_once(FILES_BASE_ADDRESS."/template/footer.php");?>


