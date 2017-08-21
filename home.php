<?php
$title='home';
include_once("template/header.php");?>

<div class="container">
<?php  if($_SESSION['reserva_sala_tipo_usuario']==1):?>
	
    <div class="row">
        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-10 col-xs-10 col-xl-offset-2 col-lg-offset-2 col-md-offset-2 col-xs-offset-1 col-sm-offset-1">
            <a href="<?php echo BASE_URL; ?>/salas/lista" class="MyButton">
                <img src="template/imgs/usuario.png" />Usuários
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-10 col-xs-10 col-xl-offset-2 col-lg-offset-2 col-md-offset-2 col-xs-offset-1 col-sm-offset-1">
            <a href="<?php echo BASE_URL; ?>/salas/lista" class="MyButton">
                <img src="template/imgs/salas.png" />Salas
            </a>
        </div>
    </div>
<?php endif; ?>
    <div class="row">
        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-10 col-xs-10 col-xl-offset-2 col-lg-offset-2 col-md-offset-2 col-xs-offset-1 col-sm-offset-1">
            <a href="<?php echo BASE_URL; ?>/reservas/lista" class="MyButton">
                <img src="template/imgs/reserva.png" />Reservas
            </a>
        </div>
    </div>

</div>

<?php include_once("template/footer.php");?>
