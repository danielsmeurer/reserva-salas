<?php 
$pagegroup='reservas';
$title='Reservas de Salas';
include_once("template/header.php");
$usuarios = new Usuarios;
$salas = new Salas;
$reservas = new Salas_Reserva;
$lista_salas = $salas->listar();
$lista_reservas = $reservas->listar();

$data_atual = $today = date("d/m/Y"); ?>
<h1 class="title"><?php echo $title ;?></h1>
<p><a class="btn btn-primary" href="cadastro"> <span  class="glyphicon glyphicon-plus"> </span> Adicionar</a></p>
<?php
if($lista_reservas):?>
<div class="retorno_delete_reserva"></div>
<div id="lista_reservas">
<div id='datas_salas'></div>
<div id="dia selecionado">
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
<?php  
	setlocale(LC_ALL, 'pt_BR');
	$data_extenso = date('d M  Y');
	$data=date('Y-m-d');
	echo $data_extenso;
?>
	<table class="table">
	<tr>
		<th>Hora</th>
		<th>sala</th>
		<th>usuario</th>		
	</tr>
	<?php  $inicio= $reservas->horario_inicio;
			$fim =  $reservas->horario_fim;

			for($i=$inicio; $i<=$fim; $i++){ 
				$hora = $i;
				if($hora<10){
				$hora='0'.$hora;			
				}
				$hora=$hora.':00:00';

				$res = $reservas->consulta_reserva_data_hora( array('data' => $data, 'hora' =>$hora ) );
				var_dump($res);

			?>
			<tr>
				<td><?php echo $hora; ?></td>
				<td></td>
				<td></td>
			</tr>
				
	<?php }	 ?>
	 </table>
</div>
<br>
<table class="table">
<thead>
	<tr>
		<th>N°</th>
		<th>Sala</th>
		<th>Data</th>
		<th>Hora</th>
		<th>Usuário</th>		
		<th>Excluir</th>
	</tr>
</thead>
<tbody>
<?php foreach ($lista_reservas as $reserva): 
$hora = explode(':',$reserva['hora']);
$hora = $hora[0].'h';
$data = $data= explode('-',$reserva['data']);
$data = $data[2].'/'.$data[1].'/'.$data[0];
$usuario= $usuarios->get_User_By_ID($reserva['user_id'])[0]['nome'];
$sala=$salas->get_sala($reserva['sala_id_sala'])['nome_sala'];
?>
<tr>
	<td><?php echo $reserva['id_reserva'] ;?></td>
	<td><?php echo $sala;?></td>
	<td><?php echo $data;?></td>
	<td><?php echo $hora;?></td>
	<td><?php echo $usuario ;?></td>	
	<td>
	<?php if($idlogado==$reserva['user_id']): ?>	
		<a class="reserva_excluir btn btn-danger" data-target="<?php echo $reserva['id_reserva'] ;?>">
		 <span  class="glyphicon glyphicon-minus"> </span> Excluir</a>
	<?php endif; ?>	
	</td>
</tr>

<?php  endforeach;?>
</tbody>
</table>
<?php else: ?>
<p>Não existem reservas ainda.<p>
<?php endif; ?>
</div>

<!-- Modal delete-->
<div class="modal fade" id="delete-modal-reserva" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
  <div class="modal-dialog" role="document">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalLabel">Excluir Reserva</h4>
      </div>
      <div class="modal-body">
        Deseja realmente excluir esta Reserva?
      </div>
      <div class="modal-footer">
        <button type="button" id="confirm" class="btn btn-primary" >Sim</button>
 		<button type="button" class="btn btn-default" data-dismiss="modal">N&atilde;o</button>
      </div>
    </div>
  </div>
</div> <!-- /.modal delete--> 

<?php  include_once("template/footer.php");?>