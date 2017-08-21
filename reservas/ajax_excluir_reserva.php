<?php header("Content-type: text/html; charset=utf-8");
if(!isset($_POST['id_reserva']))die('Acesso não Autorizado');
//include_once("loader.php");
$reservas = new Salas_Reserva;
$excluir = $reservas->excluir($_POST['id_reserva']);
echo json_encode($excluir);

?>