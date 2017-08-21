<!DOCTYPE html>
<html>
<head>
	<?php $title = 'Área de Login' ;?>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
 	 <meta name="author" content="Daniel Meurer">
	<title><?php echo $title; ?> </title>	
	<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="http://fontawesome.io/assets/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo BASE_URL;?>/template/css/style.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="<?php echo BASE_URL;?>/template/js/script.js"></script>
</head>
<body>
<?php
if(isset($_POST['logar'])){
	$logar = $login->logar($_POST['login'], $_POST['senha']);	
	if(isset($_SESSION['msg']) and $_SESSION['msg']):
		$msg= $_SESSION['msg'];
		if(isset($msg['error'])):?>
			<div class="alert alert-danger container"><a data-dismiss="alert" class="close">×</a><center><?php echo $msg['error']; ?></center></div>
	<?php 
		endif; 
	endif; 
}?>
<div class="container clearfix">
	<div id="area-login" class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
		<h3><?php echo $title; ?></h3>
		<form id="form_login" class="" name="form_login" action="area_de_login" method="post">
			<p><label for="login">Login</label></p>
			<p><input  type="text" name="login" value="<?php echo (isset($_POST['login'])) ? $_POST['login'] : ''; ?>"></p>			
			<p><label for="senha">Senha</label></p>
			<p><input type="password" name="senha" value="<?php echo (isset($_POST['senha'])) ? $_POST['senha'] : ''; ?>"></p>
			<p>
				<input class="btn btn-primary" type="submit" name="logar" value="Logar">
			</p>
		</form>
	</div>
</div>
</body>
</html>