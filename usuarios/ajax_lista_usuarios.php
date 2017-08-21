<?php header("Content-type: text/html; charset=utf-8");
$usuarios = new Usuarios;
$lista_usuarios = $usuarios->listarUsuarios();
if($lista_usuarios):?>
<?php foreach ($lista_usuarios as $user): ?>
<tr>
	<td><?php echo $user['nome'] ;?></td>
	<td><?php echo $user['email'] ;?></td>
	<td><?php echo $user['login'] ;?></td>
	<td>
		<a class="btn btn-primary" href="<?php echo $user['id_user'] ;?>" > <span class="glyphicon glyphicon-pencil"></span> Editar </a>
	</td>
	<td><?php if(isset($user['tipo']) and $user['tipo']>1):?>  
    <a class="user_excluir btn btn-danger" data-target="<?php echo $user['id_user'] ;?>">
     <span  class="glyphicon glyphicon-minus"> </span> Excluir</a><?php endif;?>
    </td>
</tr>

<?php  endforeach;?>
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
<script src="<?php echo BASE_URL;?>/template/js/script.js"></script>