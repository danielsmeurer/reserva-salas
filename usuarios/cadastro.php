<?php
 $tipo=(isset($admin))? $admin: 2;
 if(isset($_POST["Cadastra_usuario"])){
 	$usuario = array(
		'nome' => $_POST['nome'],
		'email' =>  $_POST['email'],
		'login' =>  $_POST['login'],
		'senha' => $_POST['senha'],
		'conf_senha' => $_POST['conf_senha'],
		'tipo' =>  $tipo		
		
	);	

	$cadastrar= $user->cadastrarUsuario($usuario);	
}

$pagegroup="usuarios";
$title='Cadastro de  Usuário';
include_once("template/header.php");?>
<?php echo (isset($admin))? "<div class='alert alert-info'><a data-dismiss='alert' class='close'>x</a>Cadastre o usuário administrador do sistema</div>":"";?>
<h1 class="title"><?php echo $title ?></h1>

<?php if(isset($cadastrar['error']) and $cadastrar['error']): ?>
<div class="alert alert-danger"><a data-dismiss="alert" class="close">×</a>
<?php echo $cadastrar['error']['main']; ?></div>
<?php endif;?>
<?php if(isset($cadastrar['sucesso'])): ?>
<div class="alert alert-success">
<a data-dismiss="alert" class="close">×</a><?php echo $cadastrar['sucesso']; ?></div>
<?php endif;?>
<form id="usuario_form_cadastro" action="cadastro" method="post">
	<p><label for="nome">Nome</label><br><input id="nome" type="text" name="nome" value="<?php echo (isset($usuario['nome'])) ? $usuario['nome'] : "" ; ?>">

	<?php if(isset($cadastrar['error']['nome'])): ?>
		<br><span class="error"><?php echo $cadastrar['error']['nome'];?> </span>
	<?php endif;?>	
	</p>
	<p><label for="email">E-mail</label><br><input id="email" type="email" name="email" value="<?php echo (isset($usuario['email'])) ? $usuario['email'] : "" ; ?>">
	<?php if(isset($cadastrar['error']['email'])): ?>
		<br><span class="error"><?php echo $cadastrar['error']['email'];?> </span>
	<?php endif;?>	
	</p>

	<p><label for="login">Login</label><br> <input type="text" name="login" value="<?php echo (isset($usuario['login'])) ? $usuario['login'] : "" ; ?>">
	<?php if(isset($cadastrar['error']['login'])): ?>
		<br><span class="error"><?php echo $cadastrar['error']['login'];?> </span>
	<?php endif;?>	
	</p>
	<p><label for="senha">Senha</label><br>	<input id="senha" type="password" name="senha" value="<?php echo (isset($usuario['senha'])) ? $usuario['senha'] : "" ; ?>">
	<?php if(isset($cadastrar['error']['senha'])): ?>
		<br><span class="error"><?php echo $cadastrar['error']['senha'];?> </span>
	<?php endif;?>	
	</p>
	<p><label for="conf_senha">Confirmação de senha</label><br>	<input id="conf_senha" type="password" name="conf_senha" value="<?php echo (isset($usuario['conf_senha'])) ? $usuario['conf_senha'] : "" ; ?>">
	<?php if(isset($cadastrar['error']['conf_senha'])): ?>
		<br><span class="error"><?php echo $cadastrar['error']['conf_senha'];?> </span>
	<?php endif;?>	
	</p>

	<p><input class="btn btn-primary" type="submit" name="Cadastra_usuario" value="Enviar"></p>
</form>

<a class="btn btn-link" href="<?php echo BASE_URL ?>"> <span class="glyphicon glyphicon-arrow-left" ></span> Voltar</a>

<?php 
unset($_SESSION['msg']);
include_once("template/footer.php");?>