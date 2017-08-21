<?php
header("Content-type: text/html; charset=utf-8");
/**
 * Usuarios
 *
 * package		Usuarios
 * author		Daniel Soares Meurer
 * copyright	Copyright (c) 2017, Daniel Soares Meurer (danielsmeurer@gmail.com) 
  */

class Usuarios{
	protected $usuario=null;
	private $table = "usuarios";
	protected $db= null;
	public function __construct(){
		$pdo= new Database;
		$this->db = $pdo->getInstance();
		if(!isset($_SESSION)) session_start();
	}
	/**
   * Cadastra um usuario
   *
   * @param array $usuario - dados do usuario
   * @return mix - retorna mensagem de sucesso ou falha, em outro caso retorna FALSE;
   */
	public function cadastrarUsuario($usuario=false){
		/*Validando os campos*/
		if($usuario && is_array($usuario)){
			$msg['error']=false;
			if(empty($usuario['nome'])){
				$msg['error']['nome']="O preenchimento do campo Nome é obrigatório.";
			}
			
			if(strlen($usuario['login'])<5){
				$msg['error']['login']="O Login deve ter pelo menos 5 digitos.";				
			}
			elseif($this->verifica_login($usuario['login'])){ 
				$msg['error']['login']="Este login já existe em nosso cadastro";
			}
			if($usuario['email']==''){
				$msg['error']['email']="O preenchimento do campo E-mail é obrigatório.";
			}
			elseif(!filter_var($usuario['email'], FILTER_VALIDATE_EMAIL)){
				$msg['error']['email']="Digite um email válido.";			
			}
			elseif($this->verificaDadosUsuario(array('email'=>$usuario['email']))){$msg['error']['email']="Já existe um usuário cadastrado com este email.";	
			}		

			if($usuario['senha']==''){
				$msg['error']['senha']="O preenchimento do campo Senha é obrigatório.";
			}
			elseif(strlen($usuario['senha'])<5){
				$msg['error']['senha']="A Senha deve ter pelo menos 5 digitos.";
			}
			
			if($usuario['conf_senha']!==$usuario['senha']){
				$msg['error']['conf_senha']="O campo confirmação de Senha deve ser preenchido igual ao campo Senha.";
			}

			if($msg['error']){
				$msg['error']['main']= 'Erros foram encontrados no prenchimento dos campos do formulário. Verifique se os campos foram preenchidos corretamente.';	
				return $msg;			
			}
			/*Inserindo dados no Banco de Dados*/
			$usuario['nome'] =  filter_var ( $usuario['nome'], FILTER_SANITIZE_STRING);
			$usuario['email']=	filter_var ( $usuario['email'], FILTER_SANITIZE_EMAIL);
			$usuario['login']= 	filter_var ( $usuario['login'], FILTER_SANITIZE_STRING);
			$usuario['senha']= 	sha1(filter_var ( $usuario['senha'], FILTER_SANITIZE_STRING));
			$usuario['tipo'] = filter_var ( $usuario['tipo'], FILTER_SANITIZE_NUMBER_INT);
			$sql="INSERT INTO $this->table(	nome, email, login, senha, tipo) VALUES( ?, ?,  ?, ?, ? )";
			$stmt = $this->db->prepare($sql);
			$stmt -> bindValue(1, $usuario['nome'], PDO::PARAM_STR);
			$stmt -> bindValue(2, $usuario['email'],PDO::PARAM_STR);
			$stmt -> bindValue(3, $usuario['login'],PDO::PARAM_STR);
			$stmt -> bindValue(4, $usuario['senha'],PDO::PARAM_STR);
			$stmt -> bindValue(5, $usuario['tipo'], PDO::PARAM_INT);
			if(!$stmt ->execute()){
				//var_dump($stmt ->errorInfo());
				$msg['error']['main']= "Não foi possivel efetuar  o cadastro de usuário.";				
			}			
			else{
				$msg['sucesso'] = "Usuário cadastrado com sucesso.";				
			}
			return $msg;

		}
		else{
			return FALSE;
		}			
		
	}
	// função de ediçao de usuarios 
	public function editar_usuario($usuario=false){
		
		if(!(isset($usuario['id_user'])) or !(is_numeric($usuario['id_user']))) return FALSE;
		$não_atualizar_email=false;
		$msg['error']=false;
		if(empty($usuario['nome'])){
			$msg['error']['nome']="O preenchimento do campo Nome é obrigatório.";
		}
		if(empty($usuario['email'])){
			$msg['error']['email']="O preenchimento do campo E-mail é obrigatório.";
		}
		elseif(!filter_var($usuario['email'], FILTER_VALIDATE_EMAIL)){
			$msg['error']['email']="Digite um email válido.";			
		}
		elseif(($usuario['email']!=$usuario['email_atual']) && ($this->verificaDadosUsuario(array('email'=>$usuario['email'])))){
				$msg['error']['email']="Já existe um usuário cadastrado com este email.";	
			}
		else{
			$não_atualizar_email="true";
		}


		if($msg['error']){
			$msg['error']['main']= 'Erros foram encontrados no prenchimento dos campos do formulário. Verifique se os campos foram preenchidos corretamente.';	
			$_SESSION['msg']['error']=$msg['error'];
			return false;
		}	
		if($não_atualizar_email){
			$sql = "UPDATE $this->table SET nome = ?  WHERE id_user =?";
			$stmt = $this->db->prepare($sql);
			$stmt -> bindValue(1, $usuario['nome'], PDO::PARAM_STR);
			$stmt -> bindValue(2, $usuario['id_user'],PDO::PARAM_INT);
		}
		else{
			$sql = "UPDATE $this->table SET nome = ?, email = ?  WHERE id_user =?";
			$stmt = $this->db->prepare($sql);
			$stmt -> bindValue(1, $usuario['nome'], PDO::PARAM_STR);
			$stmt -> bindValue(2, $usuario['email'],PDO::PARAM_STR);
			$stmt -> bindValue(3, $usuario['id_user'],PDO::PARAM_INT);
		}
		if(!$stmt ->execute()){
			//var_dump($stmt ->errorInfo());
			$msg['error']['main']= "Não foi possivel efetuar  a edição de usuário.";
			$_SESSION['msg']['error']=$msg['error'];
			return false;		
		}			
		$_SESSION['msg']['sucesso'] = "Usuário editado com sucesso.";
		return true;
	}

	//Retorna lista com todos usuarios cadastrados
	public function listarUsuarios(){
		$sql="SELECT * FROM $this->table ORDER BY nome";
		$stmt = $this->db->prepare($sql);
		$stmt ->execute();
		if($stmt->rowCount()>0) return $stmt->fetchAll(PDO::FETCH_ASSOC);
		return FALSE;
	}
//Busca usuario pelo id fornecido
	public function get_User_By_ID($id=false){
		if(!$id) return false;
		$this->usuario= $this->verificaDadosUsuario(array('id_user'=>$id));
		return $this->usuario;
	}
	
	//Verifica se existe o login informado 
	protected function verifica_login($login=false){
		if(!$login) return FALSE;
		$sql="SELECT * FROM usuarios WHERE login=?";		
		$stmt = $this->db->prepare($sql);
		$stmt -> bindValue(1, $login, PDO::PARAM_STR);
		$stmt ->execute();
		if($stmt->rowCount()>0) return TRUE;
		return FALSE;
	}

	/**
   * verifica se existem usuario administradores
   *
   * @return bool - retorna TRUE se hover usuário tipo admin(1);
   */
  
  	public function verifica_se_ha_admin_user(){
  		$admin = $this->verificaDadosUsuario(array('tipo' => 1));
  		if(!$admin)return false;
  		return true;
  	}

	//consulta dados fornecidos em um array na tabela usuario
	protected  function verificaDadosUsuario($usuario=false){
		if(!$usuario || !(is_array($usuario))) return FALSE;
		$sql = "SELECT * FROM $this->table WHERE ";
		$where= " ";
		$i = 0;
		$totalitens = count($usuario);
		/*montar sql prepared*/
		foreach ($usuario as $key=>$value) {
			$i++;
			$sql .= $key.' = ?';
			if($i<$totalitens){
				$sql .= '  AND  '; 
			}
		}
		
		$stmt = $this->db->prepare($sql);	
		//faz o bind do valor para consulta
		$i = 0;
		foreach ($usuario as $key=>$value) {
			$i++;
			$parampdo = (is_int($value)) ? PDO::PARAM_INT : PDO::PARAM_STR;
			$stmt -> bindValue($i, $value, $parampdo);					
		}
		$stmt ->execute();
		if($stmt->rowCount()>0) return $stmt->fetchAll(PDO::FETCH_ASSOC);
		return FALSE;
	}

	function getUserByLogin($login=false){		
		if(!$login) return FALSE;
		$sql="SELECT * FROM usuarios WHERE login=?";		
		$stmt = $this->db->prepare($sql);
		$stmt -> bindValue(1, $login, PDO::PARAM_STR);
		$stmt ->execute();
		if($stmt->rowCount()>0) return $stmt->fetch(PDO::FETCH_ASSOC);
		return FALSE;
	}

	//Exclui o usuario baseado no id informado e retorna true em caso positivo
	public function excluirUsuario($id=false){
		if(!$id) return false;
		$this->excluir_agendamentos_usuario($id);
		$sql="DELETE FROM $this->table WHERE id_user = ?";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(1, $id, PDO::PARAM_INT);
		$return = $stmt->execute();
		if(!$return){
			return false;
		}
		return true;
	}
//Exclui agendamento de salas do usuário;
	public function excluir_agendamentos_usuario($id){
		$reservas = new Salas_Reserva;
		if($reservas->excluir_agendamentos_usuario($id)){
			return true;
		}
		return false;		
	}

	//Trocar senha
	public function trocar_senha($id=false, $senha=false, $confsenha=false){
		$msg['error']=false;
		if($senha==''){
			$msg['error']['senha']="O preenchimento do campo Senha é obrigatório.";
		}
		elseif(strlen(trim($senha))<5){
			$msg['error']['senha']="A Senha deve ter pelo menos 5 digitos.";
		}
		
		if(trim($confsenha)!=trim($senha)){
			$msg['error']['conf_senha']="O campo confirmação de Senha deve ser preenchido igual ao campo Senha.";
		}

		if(!$msg['error']){
			$msg['error']['main']= 'Erros foram encontrados no prenchimento dos campos do formulário. Verifique se os campos foram preenchidos corretamente.';	
			$_SESSION['msg']['error']= $msg['error'];
			return false;			
		}
		
		$senha = sha1(filter_var ( $senha, FILTER_SANITIZE_STRING));
		$sql = "UPDATE $this->table SET senha = ?  WHERE id_user =?";
		$stmt = $this->db->prepare($sql);
		$stmt -> bindValue(1, $senha, PDO::PARAM_STR);
		$stmt -> bindValue(2, $id,PDO::PARAM_INT);
		

		if(!$stmt->execute()){
			//var_dump($stmt ->errorInfo());
			$msg['error']['main']= "Não foi possivel mudar senha.";
			$_SESSION['msg']['error']=$msg['error'];
			return false;		
		}			
		$_SESSION['msg']['sucesso'] = "Nova senha cadastrada.";
		return true;
	}
	
}
 
