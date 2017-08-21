<?php
header("Content-type: text/html; charset=utf-8");
/**
 * Salas
 *
 * package		Salas
 * author		Daniel Soares Meurer
 * copyright	Copyright (c) 2017, Daniel Soares Meurer (danielsmeurer@gmail.com) 
  */
Class Salas{
	public $sala;
	private $table = 'salas';
	protected $db;
	public function __construct(){
		$pdo= new Database;
		$this->db=$pdo->getInstance();
		if(!isset($_SESSION)) session_start();
	}

	//cadastra unma nova sala no banco de dados return boolean
	public function criar( $sala=false ){
		//valida dados dados
		$msg['error']=false;
		$sala = filter_var($sala, FILTER_SANITIZE_STRING);
		if(empty($sala)){			
			$msg['error']['nome'] = "O campo Nome da Sala é obrigátorio.";			
		}
		elseif($this->verifica_se_nome_sala_existe($sala)){
			$msg['error']['nome'] = "Já existe uma sala com este nome. Escolha outro.";
		}
		
		if($msg['error']){
			$msg['error']['main'] = "Verique o preenchimeto dos campos.";
			$_SESSION['msg']=$msg;			
			return false;
		}
		//exit("2");
			//Se não a erros faz inserção no BD
		
		$sql = "INSERT INTO $this->table (nome_sala ) VALUES(?) ";
		$stmt=$this->db->prepare($sql);
		$stmt -> bindValue(1, $sala, PDO::PARAM_STR);
		//exit("4");
		if(!$stmt ->execute()){
			var_dump($stmt ->errorInfo());
			return false;
		}		
		$_SESSION['msg']['sucesso']='Sala cadastrada com sucesso!';
		return true;

	}

	//edita sala pelo id informado return boolean.
	public function editar($sala=false){
		if(!$sala or !isset($sala['id_sala']) or !is_numeric($sala['id_sala'])) return false;
		$msg['error']=false;
		if(empty($sala['nome_sala'])){
			$msg['error']['nome'] = "O campo Nome da Sala é obrigátorio.";
		}
		elseif($this->verifica_se_nome_sala_existe($sala['nome_sala'])){
			$msg['error']['nome'] = "Já existe uma sala com este nome. Escolha outro.";
		}		
		else{
			$id = filter_var($sala['id_sala'],FILTER_SANITIZE_NUMBER_INT);
			$id = filter_var($sala['nome_sala'],FILTER_SANITIZE_STRING);
		}
		
		if($msg['error']){
			$msg['error']['main'] = "Verique o preenchimeto dos campos.";
			$_SESSION['msg']=$msg;
			return false;
		}
		$sql = "UPDATE $this->table SET nome_sala = ?  WHERE id_sala =?";			
		$stmt=$this->db->prepare($sql);
		$stmt -> bindValue(1, $sala['nome_sala'], PDO::PARAM_STR);
		$stmt -> bindValue(2, $sala['id_sala'], PDO::PARAM_INT);
		if(!$stmt ->execute()){
			return false;
		}
		$_SESSION['msg']['sucesso']='Sala cadastrada com sucesso!';
		return true;
	}

	//consulta todas salas cadastradas
	public function listar(){
		$sql = "SELECT * FROM $this->table ORDER BY nome_sala";			
		$query=$this->db->query($sql); 
		$salas= $query->fetchAll(PDO::FETCH_ASSOC);
		if($salas){
			return $salas;
		}
		return false;				
	}

	//Exclui uma sala
	public function excluir($id=false){
		if(!$id or !is_numeric($id))return false;
		$this->excluir_agendamentos_sala($id, 'reservas');
		$sql="DELETE FROM $this->table WHERE id_sala = ?";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(1, $id, PDO::PARAM_INT);
		$return = $stmt->execute();
		if(!$return){
			return false;
		}
		return true;
	}

	public function excluir_agendamentos_sala($id, $table){
		$sql="DELETE FROM $table WHERE sala_id_sala = ?";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(1, $id, PDO::PARAM_INT);
		if(!$retorno = $stmt->execute()){
			//var_dump($stmt ->errorInfo());
			return false;
		}
		return true;
	}

	//busca uma sala pelo id
	public function get_sala($id=false){
		if(!$id or !is_numeric($id))return false;
		$id = filter_var($id,FILTER_SANITIZE_NUMBER_INT);
		$sql="SELECT * FROM $this->table WHERE id_sala = ?";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(1, $id, PDO::PARAM_INT);		
		if($stmt->execute()) return $stmt->fetch(PDO::FETCH_ASSOC);
		return false;
	}

	//busca uma sala pelo nome
	public function verifica_se_nome_sala_existe($nome=false){
		if(!$nome)return false;
		$id = filter_var( $nome, FILTER_SANITIZE_STRING);
		$sql="SELECT * FROM $this->table WHERE nome_sala = ?";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(1, $nome, PDO::PARAM_STR);		
		if($stmt->execute()) return $stmt->fetch(PDO::FETCH_ASSOC);
		return false;
	}

}