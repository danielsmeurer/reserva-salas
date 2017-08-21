<?php
$pagegroup='reservas';
$title='Cadastro de  Reservas de Salas';
include_once("template/header.php");
$usuarios = new Usuarios;
$salas = new Salas;
$reservas = new Salas_Reserva;
$data_atual = $today = date("d/m/Y"); 
$lista_salas = $salas->listar();
$login=false;
if(!empty($_SESSION['reserva_sala_login'])){
	$login=$_SESSION['reserva_sala_login'];
}
$user=$usuarios->getUserByLogin($login);
if(isset($_POST['Cadastra_Reserva'])){
	$reservar = $reservas->reservar($_POST);

}


?>
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
<form id="reserva_form_cadastro" action="" method="post">
<input name="id_user" type="hidden" value="<?php echo (isset($user['id_user'])) ? $user['id_user'] : 'N'; ?>">
<label for="sala">Sala</label>

<!--Salas -->
<select name="sala" id="">
<?php if($lista_salas):?>
<p>	<option value="0" > Selecione uma sala</option>
 <?php foreach ($lista_salas as $sala) : 
 ?>
 	
	<option <?php echo (isset($_POST['sala']) and (trim($_POST['sala'])==trim($sala['id_sala']))) ? 'selected' : ''; ?> value="<?php echo $sala['id_sala'] ?>"><?php echo $sala['nome_sala'];?></option>
<?php endforeach;
else:?>	
	Não Existem salas cadastradas
<?php endif; ?>
</select><br>
<?php if(isset($_SESSION['msg']['error']['sala'])): ?>
	<span class="error"><?php echo $_SESSION['msg']['error']['sala'];?> </span>
<?php endif;?> 
</p>

<!--FIM Salas -->
<!--data-->
<p>
	<label for="data">Data</label>
	<input id="data" type="text" name="data" value="<?php echo (isset($_POST['data'])) ? $_POST['data'] : $data_atual ; ?>">
	<br>
	<?php if(isset($_SESSION['msg']['error']['data'])): ?>
	<span class="error"><?php echo $_SESSION['msg']['error']['data'];?> </span>
<?php endif;?> 
</p>
<!-- Fim data-->

<!--hora-->
<p>
	<label for="hora">Hora</label>
	<select name="hora" id="hora">
	<?php for($i=$reservas->horario_inicio; $i<=$reservas->horario_fim; $i++){ ?>
		<option <?php echo (isset($_POST['hora']) and (trim($_POST['hora'])==$i)) ? 'selected' : ''; ?> value="<?php echo $i ; ?>"><?php echo ($i<10) ? '0'.$i : $i; ?>h</option>
	<?php } ?>
	</select>
	<br>
	<?php if(isset($_SESSION['msg']['error']['hora'])): ?>
	<span class="error"><?php echo $_SESSION['msg']['error']['hora'];?> </span>
<?php endif;?>
</p>
<!--FIM hora-->
<p><input class="btn btn-primary" type="submit" name="Cadastra_Reserva" value="Enviar"></p>
</form>

<a class="btn btn-link" href="<?php echo BASE_URL ?>"> <span class="glyphicon glyphicon-arrow-left" ></span> Voltar</a>
<?php unset($_SESSION['msg']);?>
<script src="<?php echo BASE_URL;?>/template/js/mask.js"></script>
<script>$('document').ready(function(){
	$( "#data" ).mask("99/99/9999");
	
})
</script>
<?php include_once("template/header.php");?>