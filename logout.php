<?php
$login= new Usuarios_Login;
$login->logOut();
header(BASE_URL.'/area_de_login');