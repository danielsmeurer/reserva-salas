<?php header("Content-type: text/html; charset=utf-8");
$salas = new Salas;
$lista_salas = $salas->listar();
//var_dump($lista_salas);
if($lista_salas):?>
<?php foreach ($lista_salas as $sala): ?>
<tr>
  <td><a href="perfil.php/<?php echo $sala['id_sala'] ;?>"> <span class="glyphicon glyphicon-eye-open"></span> <?php echo $sala['nome_sala'] ;?></a></td> 
  <td>
    <a class="btn btn-primary" href="editar.php/<?php echo $sala['id_sala'] ;?>" > <span class="glyphicon glyphicon-pencil" ></span> Editar </a>
  </td>
  <td>
    <a class="sala_excluir btn btn-danger" data-target="<?php echo$sala['id_sala'] ;?>">
     <span  class="glyphicon glyphicon-minus"> </span> Excluir</a>
  </td>
</tr>

<?php  endforeach;
 else: ?>
<p>Nenhuma sala cadastrada<p>
<?php endif; ?>

<!-- Modal delete-->
<div class="modal fade" id="delete-modal-sala" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
  <div class="modal-dialog" role="document">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalLabel">Excluir Sala</h4>
      </div>
      <div class="modal-body">
        Deseja realmente excluir esta Sala?
      </div>
      <div class="modal-footer">
        <button type="button" id="confirm" class="btn btn-primary" >Sim</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">N&atilde;o</button>
      </div>
    </div>
  </div>
</div> <!-- /.modal delete--> 
<script src="<?php echo BASE_URL;?>/template/js/script.js"></script>