<?php 
if(!isset($_SESSION['reserva_sala_tipo_usuario'])){session_start();}
if($_SESSION['reserva_sala_tipo_usuario']>1){ exit("Somente Administrador tema acesso a esta pagína!");}
$pagegroup="salas";
$title="Salas";
include_once("template/header.php");
$salas = new Salas;
$lista_salas = $salas->listar();?>
<h1 class="title"><?php echo $title ;?></h1>
<p><a class="btn btn-primary" href="cadastro"> <span  class="glyphicon glyphicon-plus"> </span> Adicionar</a></p>
<?php
if($lista_salas):?>
<div class="retorno_delete_sala"></div>
<div id="lista_salas">
<table class="table">
<thead>
	<tr>
		<th>Sala</th>
		<th>Editar</th>
		<th>Excluir</th>
	</tr>
</thead>
<tbody>
<?php foreach ($lista_salas as $sala): ?>
<tr>
	<td><strong><?php echo $sala['nome_sala'] ;?></strong></td>	
	<td>
		<a class="btn btn-primary" href="editar.php/<?php echo $sala['id_sala'] ;?>" > <span class="glyphicon glyphicon-pencil" ></span> Editar </a>
	</td>
	<td>
		<a class="sala_excluir btn btn-danger" data-target="<?php echo$sala['id_sala'] ;?>">
		 <span  class="glyphicon glyphicon-minus"> </span> Excluir</a>
	</td>
</tr>

<?php  endforeach;?>
</tbody>
</table>
<?php else: ?>
<p>Nenhuma sala cadastrada<p>
<?php endif; ?>
</div>

<!-- Modal delete-->
<div class="modal fade" id="delete-modal-sala" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
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