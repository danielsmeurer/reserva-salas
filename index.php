<?php 
require_once('loader.php');
session_start();
$login = new Usuarios_Login;
$logado=$login->verificaSeEstaLogado();
$user = new Usuarios;
$usuario_admin = $user->verifica_se_ha_admin_user();
$url = (isset($_GET['url']) and !empty($_GET['url'])) ? $_GET['url']: 'home';
$pagegroup='home';

//verifica se existem usuarios cadastrados, caso nao haja envia para o cadastro de usuarios
if(!$usuario_admin){
	$admin ='1';
	$url='usuarios/cadastro';
}
elseif(!$logado){
	//se não estiver logado manda para area de login.
	$url= 'area_de_login';
}

//$url = array_filter(explode('/',$url));

$file = $url.'.php';
if(is_file($file)){
	include $file;
}else{
	include '404.php';
}		


