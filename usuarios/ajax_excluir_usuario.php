<?php header("Content-type: text/html; charset=utf-8");
if(!isset($_POST['id_user']))die('Acesso não Autorizado');
//include_once("loader.php");
$usuarios = new Usuarios;
$excluir = $usuarios->excluirUsuario($_POST['id_user']);
echo json_encode($excluir);

?>