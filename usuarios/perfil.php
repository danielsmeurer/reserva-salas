<?php
$uri = $_SERVER ['REQUEST_URI'];
$uri = explode('perfil.php',$uri);
$id= str_replace('/','', $uri[1]);

if(!is_numeric($id))die("Acesso a Pagina Autorizado!");
$pagegroup="usuarios";
$title='Perfil Usuário';
include_once('../loader.php');
include_once FILES_BASE_ADDRESS."/template/header.php";

$usuarios = new Usuarios;
$usuario=$usuarios->get_User_By_ID($id);

?>
<h1><?php echo $title;?></h1>	
<div class="perfil">
	<p><span style="font-size: 90px;" class="glyphicon glyphicon-user"></span></p>
	<p>Nome: <?php echo $usuario[0]['nome']; ?></p>
	<p>E-mail: <?php echo $usuario[0]['email']; ?></p>
	<p>Login: <?php echo $usuario[0]['login']; ?></p>
	<p>Tipo: <?php echo ($usuario[0]['tipo']>1)? 'Usuário' : 'Administrador'; ?></p>	
	<p><a class="btn btn-primary" href="<?php echo  BASE_URL ?>/usuarios/editar.php/<?php echo $usuario[0]['id_user'] ;?>" > <span class="glyphicon glyphicon-pencil"></span> Editar </a></p>
</div>


<?php include_once(FILES_BASE_ADDRESS."/template/footer.php");?>



