<?php 
if(!isset($_SESSION['reserva_sala_tipo_usuario'])){session_start();}
if($_SESSION['reserva_sala_tipo_usuario']>1){ exit("Somente Administrador tema acesso a esta pagína!");}
$pagegroup="usuarios";
$title="Usuários";
include_once("template/header.php");
$usuarios = new Usuarios;
$lista_usuarios = $usuarios->listarUsuarios();?>
<h1 class="title"><?php echo $title ?></h1>
<p><a class="btn btn-primary" href="cadastro"> <span  class="glyphicon glyphicon-plus"> </span> Adicionar</a></p>

<?php
if($lista_usuarios):?>
<div class="retorno_delete_usuario"></div>
<div id="lista_users">
<table class="table">
<thead>
	<tr>
		<th>Nome</th>
		<th>Email</th>
		<th>login</th>
		<th>Editar</th>
		<th>Excluir</th>
	</tr>
</thead>
<tbody>
<?php foreach ($lista_usuarios as $user): ?>
<tr>
	<td><a href="perfil.php/<?php echo $user['id_user'] ;?>"> <span class="glyphicon glyphicon-eye-open"></span> <?php echo $user['nome'] ;?></a></td>
	<td><?php echo $user['email'] ;?></td>
	<td><?php echo $user['login'] ;?></td>
	<td>
		<a class="btn btn-primary" href="editar.php/<?php echo $user['id_user'] ;?>" > <span class="glyphicon glyphicon-pencil" ></span> Editar </a>
	</td>
	<td><?php?>
	<?php if(isset($user['tipo']) and $user['tipo']>1):?>	
		<a class="user_excluir btn btn-danger" data-target="<?php echo $user['id_user'] ;?>">
		 <span  class="glyphicon glyphicon-minus"> </span> Excluir</a><?php endif;?>
	</td>
</tr>

<?php  endforeach;?>
</tbody>
</table>
<?php else: ?>
<p>Nenhum usuario cadastrado<p>
<?php endif; ?>
</div>

<!-- Modal delete-->
<div class="modal fade" id="delete-modal-usuario" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
  <div class="modal-dialog" role="document">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalLabel">Excluir Item</h4>
      </div>
      <div class="modal-body">
        Deseja realmente excluir este item?
      </div>
      <div class="modal-footer">
        <button type="button" id="confirm" class="btn btn-primary" >Sim</button>
 		<button type="button" class="btn btn-default" data-dismiss="modal">N&atilde;o</button>
      </div>
    </div>
  </div>
</div> <!-- /.modal delete--> 

<?php  include_once("template/footer.php");?>