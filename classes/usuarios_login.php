<?php
header("Content-type: text/html; charset=utf-8");
Class  Usuarios_Login extends Usuarios{
	public $user;
	public function __construct(){
		parent::__construct();

	}
/**
* Verifica se existe usuario Logado
* @return boolean - Se o usuário foi logado ou não
*/
	public function verificaSeEstaLogado(){
		if(empty($_SESSION)){return FALSE;}
		if(!isset($_SESSION['reserva_sala_nome_usuario']) or empty($_SESSION['reserva_sala_nome_usuario']) ){
			return FALSE;
		}
		if(!isset($_SESSION['reserva_sala_login']) or empty($_SESSION['reserva_sala_login']) ){ 
			return FALSE;
		}
		if(!isset($_SESSION['reserva_sala_tipo_usuario']) or empty($_SESSION['reserva_sala_tipo_usuario']) ){
			exit('3');
			return FALSE;
		}
		$dadosSessao = array(
				'login'=> $_SESSION['reserva_sala_login'],
				'nome'=> $_SESSION['reserva_sala_nome_usuario']
				);
		//verificando se os dados da sessão existem no BD
		if(!parent::verificaDadosUsuario($dadosSessao)){
			return FALSE;
		}
		return TRUE;
	}

/**
* efetua login de usuarios
* @param string $login- O usuário que será logado
* @param string $senha - A senha do usuário
* @return boolean - caso logado com sucesso retorna TRUE
*/
	public function logar($login=false,$senha=false){
		if(isset($_SESSION['msg']['error'])){unset($_SESSION['msg']['error']);};
		if(!$login or !$senha) return FALSE;
		$dados = array('login'=>$login, 'senha'=>sha1(filter_var ( $senha, FILTER_SANITIZE_STRING)));
		$usuario = parent::verificaDadosUsuario($dados);
		if(!$usuario) {
			$_SESSION['msg']['error']="Não foi possivel fazer o login. Verifique se o login e/ou senha informados estão corretos";
			return FALSE;
		}
		else{
			//var_dump($usuario);
			$_SESSION['reserva_sala_nome_usuario'] = $usuario[0]['nome'];
			$_SESSION['reserva_sala_login'] = $usuario[0]['login'];
			$_SESSION['reserva_sala_tipo_usuario'] = $usuario[0]['tipo'];
			header('Location: '.BASE_URL.'/home');			
		}
		return true;
		
	}

/**
* Destroi seção e envia para area de login
* @return void;
*/
	public function logOut(){
		session_destroy();
		header('Location: '.BASE_URL.'/area_de_login');
	}

}