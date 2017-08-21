<?php header("Content-type: text/html; charset=utf-8");
$usuarios = new Usuarios;
$salas = new Salas;
$reservas = new Salas_Reserva;
$lista_reservas = $reservas->listar();
if($lista_reservas):?>
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
    <a class="reserva_excluir btn btn-danger" data-target="<?php echo $reserva['id_reserva'] ;?>">
     <span  class="glyphicon glyphicon-minus"> </span> Excluir</a>
  </td>
</tr>

<?php  endforeach;
 else: ?>
<p>Não existem reservas ainda.<p>
<?php endif; ?>

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
<script src="<?php echo BASE_URL;?>/template/js/script.js"></script>