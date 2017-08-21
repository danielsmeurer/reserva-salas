<?php header("Content-type: text/html; charset=utf-8");
if(!isset($_POST['id_sala']))die('Acesso não Autorizado');
//include_once("loader.php");
$salas = new Salas;
$excluir = $salas->excluir($_POST['id_sala']);
echo json_encode($excluir);

?>