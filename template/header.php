<?php 
$login= false;
if(!isset($_SESSION['reserva_sala_nome_usuario']))
{ session_start();}
  $login = $_SESSION['reserva_sala_login'];

$usuariosheader= new Usuarios;
$usuarioheader=$usuariosheader->getUserByLogin($login);
$idlogado=$usuarioheader['id_user'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author">
	<title>.:Sistema de Reserva de Salas - <?php echo $title; ?>:.</title>	
	<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>	
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="http://fontawesome.io/assets/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="<?php echo BASE_URL;?>/template/css/style.css">  
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="<?php echo BASE_URL;?>/template/js/script.js"></script>
</head>
<body>
<header>
  <div class="container">
  <ul id="itens-header">
    <li class="col-md-10"> 
      <a class="navbar-brand left" href="<?php echo BASE_URL;?>/home" >Sistema de Reserva de Salas</a>
    </li>
    <li class="col-md-2 right">
      <div class="dropdown right">
        <a class="btn btn-link dropdown-toggle" type="button" data-toggle="dropdown">
        <?php echo $login;?>
        <span class="caret"></span><span class="glyphicon glyphicon-user" style="font-size:x-large;"></span></a>
        <ul class="dropdown-menu  ">
          <li><?php echo $usuarioheader['nome'];?></li>
          <li><?php echo (isset($usuarioheader['email'])) ? $usuarioheader['email'] : '#';?>  </li>  
          <li> tipo: <?php echo ($usuarioheader['tipo']==1) ? 'Administrador' : 'usuario';?> 
          </li>           
          <li class="divider"></li>
          <li>
          <a style="padding: 0; line-height: 5px; " href="<?php echo BASE_URL; ?>/usuarios/editar.php/<?php echo (isset($usuarioheader['id_user'])) ? $usuarioheader['id_user'] : '#';?>">Editar Perfil </a> <span style="color: transparent;">.</span>
          </li>           
          <li><p><a  class="btn btn-primary"  href="<?php echo BASE_URL;?>/logout">Sair</a></p></li>
        </ul>
      </div>      
    </li>    
  </ul>       
  </div>
</header>
<nav class="navbar navbar-inverse ">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-left">
        	<li <?php echo ($pagegroup=="home") ? 'class="active"': ''; ?>><a href="<?php echo BASE_URL;?>/home" >Início</a></li>
		  <?php if($_SESSION['reserva_sala_tipo_usuario']==1):?>
        <li <?php echo ($pagegroup=="usuarios") ? 'class="active"': ''; ?> >
          <a href="<?php echo BASE_URL;?>/usuarios/lista">Usuários</span></a>        
        </li>
		    <li <?php echo ($pagegroup=="salas") ? 'class="active"': ''; ?>><a href="<?php echo BASE_URL;?>/salas/lista">Salas</a></li>
      <?php endif; ?>
        <li>
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Reservas
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="<?php echo BASE_URL;?>/reservas/lista">Lista</a></li>
          <li ><a href="<?php echo BASE_URL;?>/reservas/cadastro">Reservar Sala</a></li>          
        </ul>
		 <?php /*   <li <?php echo ($pagegroup=="reservas") ? 'class="active"': ''; ?>><a  href="<?php echo BASE_URL;?>/reservas/lista" >Reservas</a>
        </li>		*/?>                  
      </ul>
    </div>
  </div>
</nav>

<div id="main" class="container">
  <?php unset($usuarios);?>


  

	
