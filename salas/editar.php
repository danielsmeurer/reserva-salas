<?php
if(!isset($_SESSION['reserva_sala_tipo_usuario'])){session_start();}
if($_SESSION['reserva_sala_tipo_usuario']>1){ exit("Somente Administrador tema acesso a esta pagína!");}
$uri = $_SERVER ['REQUEST_URI'];
$uri = explode('editar.php',$uri);
$id= str_replace('/','', $uri[1]);

if(!is_numeric($id))die("Acesso a Pagina Autorizado!");
$pagegroup="salas";
$title='Editar Sala';
include_once('../loader.php');
include_once FILES_BASE_ADDRESS."/template/header.php";

$salas = new Salas;
$sala=$salas->get_sala($id);
if(isset($_POST['Cadastra_sala'])){	
	$novos_dados = array('id_sala'=>$id,	'nome_sala'=> $_POST['nome']);
	$edita= $salas->editar($novos_dados);
}
?>

<h1 class="title"><?php echo $title ?></h1>

<?php if(isset($_SESSION['msg']['error']) and $_SESSION['msg']['error']): ?>
<div class="alert alert-danger"><a data-dismiss="alert" class="close">×</a>
<?php echo $_SESSION['msg']['error']['main']; ?></div>
<?php endif;?>
<?php if(isset($_SESSION['msg']['sucesso'])): ?>
<div class="alert alert-success">
<a data-dismiss="alert" class="close">×</a><?php echo $_SESSION['msg']['sucesso']; ?></div>
<?php endif;?>
<form id="sala_form_edita" action="" method="post">
	<p><label for="nome">Nome da Sala</label><br><input id="nome" type="text" name="nome" value="<?php echo (isset($sala['nome_sala'])) ?$sala['nome_sala'] : "" ; ?>">

	<?php if(isset($_SESSION['msg']['error']['nome'])): ?>
		<br><span class="error"><?php echo $_SESSION['msg']['error']['nome'];?> </span>
	<?php endif;?>	
	</p>
		
		
	<p><input class="btn btn-primary" type="submit" name="Cadastra_sala" value="Enviar"></p>
</form>

<a class="btn btn-link" href="<?php echo BASE_URL;?>/salas/lista"> <span class="glyphicon glyphicon-arrow-left" ></span> Voltar</a>

<?php 
unset($_SESSION['msg']);
include_once(FILES_BASE_ADDRESS."/template/footer.php");?>


