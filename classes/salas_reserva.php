<?php
header("Content-type: text/html; charset=utf-8");
/**
 * Reserva Salas
 *
 * author		Daniel Soares Meurer
 * copyright	Copyright (c) 2017, Daniel Soares Meurer (danielsmeurer@gmail.com) 
  */
Class Salas_Reserva extends Salas{
	private $table = 'reservas';
	protected $db;
	//horarios maximos e minimos para reserva //obs.: implemtar no banco de dados futuramente para cada sala.
	public $horario_inicio = 8;
	public $horario_fim = 21;	
	public function __construct(){		
		parent::__construct();	
		setlocale(LC_ALL, 'ptb', 'portuguese-brazil', 'pt-br', 'bra', 'brazil');
		date_default_timezone_set('America/Sao_Paulo');	
	}

	//cadastra uma reserva de salas
	public function reservar($reserva= false){	
		if(!$reserva or !isset($reserva['id_user'])) return false;
		$error = false;		
		$hoje =  date("d/m/Y");
		$hora_atual=date('H');
				
		/*Validçãodecampos */
		if($reserva['sala']==0){		
			$error['msg']['error']['sala']='Selecione uma sala!';			
		}
		//valída data
		if(empty($reserva['data'])){
			$error['msg']['error']['data']='Preencha uma Data!';			
		}
		elseif($reserva['data'] < $hoje ){
			$error['msg']['error']['data'] ='A data da reserva não pode ser anterior ao dia de hoje!';
		}
		$data_original = $reserva['data'];
		$reserva['data']=explode('/',$reserva['data']);
		$data = $reserva['data'][2].'-'.$reserva['data'][1].'-'.$reserva['data'][0];
		//fim valída data		
		//validando hora
		if(empty($reserva['hora'])){
			$error['msg']['error']['hora'] ="Escolha horário da reserva !";
		}
		elseif($reserva['hora']<$this->horario_inicio){
			$error['msg']['error']['hora'] ="A hora não pode ser menor que $this->horario_inicio h !";
		}
		elseif($reserva['hora']>$this->horario_fim){
			$error['msg']['error']['hora'] ="A hora não pode ser maior que $this->horario_fim h !";
		}
		elseif($data_original == $hoje and $reserva['hora']<=$hora_atual){	
			$error['msg']['error']['hora'] ="A reserva tem que ser para uma hora posterior a atual!";	
		}		

		$reserva['hora']=filter_var($reserva['hora'],FILTER_SANITIZE_STRING);
		if($reserva['hora']<10){
			$reserva['hora']='0'.$reserva['hora'];			
		}
		$reserva['hora']=$reserva['hora'].':00:00';

		$dados_teste = array(
			'data'=>$data , 
			'hora'=>$reserva['hora'], 
			'sala'=>$reserva['sala']
		);
		if($this->consulta_se_existe_reserva_igual($dados_teste)){
			$error['msg']['error']['hora'] = "Esta sala já está reservada para este horário!";
		}
		if($this->consulta_agendamento_usuario_neste_periodo($reserva['id_user'],$data,$reserva['hora'])){
			$error['msg']['error']['hora'] = "Você possuí um agendamento para está sala neste mesmo dia e hora! Por favor ecolha outro periodo.";
		}

		//valida hora fim

		if($error){
			$error['msg']['error']['main'] = "Verique o preenchimeto dos campos.";
			$_SESSION['msg']['error']=$error['msg']['error'];			
			return false;
		}		
		/*FIM validçãodecampos */
		
		//var_dump($reserva['hora']);exit('dd');
		//inserção no BD
		$sql = "INSERT INTO $this->table (data, hora, sala_id_sala, user_id ) VALUES(?, ?, ?, ?) ";
		$stmt = $this->db->prepare($sql);
		$stmt -> bindValue(1, $data, PDO::PARAM_STR);
		$stmt -> bindValue(2, $reserva['hora'], PDO::PARAM_STR);
		$stmt -> bindValue(3, $reserva['sala'], PDO::PARAM_INT);
		$stmt -> bindValue(4, $reserva['id_user'], PDO::PARAM_INT);
		//exit("4");
		if(!$stmt ->execute()){
			//var_dump($stmt ->errorInfo());
			return false;
		}		
		$_SESSION['msg']['sucesso']='Reserva de sala efetuada com sucesso!';
		return true;
	}

	public function listar(){
		$sql = "SELECT * FROM $this->table ORDER BY data";			
		$query=$this->db->query($sql); 
		$reservas= $query->fetchAll(PDO::FETCH_ASSOC);
		if($reservas){
			return $reservas;
		}
		return false;				
	}

	//verifica se a sala já não possui um reserva na mesma data e hora
	public function consulta_se_existe_reserva_igual($reserva=false){
		if(!$reserva) return false;
		$sql = "SELECT * FROM $this->table WHERE data = ? AND hora = ? AND sala_id_sala = ? ";
		$stmt = $this->db->prepare($sql);
		$stmt -> bindValue(1, $reserva['data'], PDO::PARAM_STR);
		$stmt -> bindValue(2, $reserva['hora'], PDO::PARAM_STR);
		$stmt -> bindValue(3, $reserva['sala'], PDO::PARAM_INT);
		if(!$stmt ->execute()){	
			//var_dump($stmt ->errorInfo());		
			return false;
		}	
		elseif($stmt->rowCount()>0) return true;		
		return false;
	}
//Verifica se o usuario já possuí reserva neste mesmo dia e hora.
	public function consulta_agendamento_usuario_neste_periodo($user_id, $data, $hora){
		$sql = "SELECT * FROM $this->table WHERE user_id = ? AND data = ? AND hora= ?";			
		$stmt = $this->db->prepare($sql);
		$stmt -> bindValue(1, $user_id, PDO::PARAM_INT);
		$stmt -> bindValue(2, $data, PDO::PARAM_STR);
		$stmt -> bindValue(3, $hora, PDO::PARAM_STR);
		if(!$stmt ->execute()){	
			//var_dump($stmt ->errorInfo());		
			return false;
		}	
		elseif($stmt->rowCount()>0) return true;		
		return false;
	}

//Exclui agendamento de salas do usuário;
	public function excluir_agendamentos_usuario($id){
		$sql="DELETE FROM $this->table WHERE user_id = ?";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(1, $id, PDO::PARAM_INT);
		$return = $stmt->execute();
		if(!$return){
			return false;
		}
		return true;
	}

//Exclui agendamento de salas de sala informada;
	public function excluir_agendamentos_sala_id($id){
		$sql="DELETE FROM $this->table WHERE sala_id_sala = ?";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(1, $id, PDO::PARAM_INT);
		$return = $stmt->execute();
		if(!$return){
			return false;
		}
		return true;
	}

	//Exclui uma reserva
	public function excluir($id=false){
		if(!$id or !is_numeric($id))return false;
		$sql="DELETE FROM $this->table WHERE id_reserva = ?";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(1, $id, PDO::PARAM_INT);
		$return = $stmt->execute();
		if(!$return){
			//var_dump($stmt ->errorInfo());	
			return false;
		}
		return true;
	}




}