<?php
require_once(FILES_BASE_ADDRESS.'/loader.php');
class Database extends PDO {
	protected static $instance;
	protected static $host = DB_HOST;
	protected static $port = DB_PORT;
	protected static $user = DB_USER;
	protected static $pass = DB_PASS;
	protected static $db   = DB_NAME;
	
	public function __construct() {		
		self::$instance = new PDO('mysql:host=' . self::$host . ';port=' . self::$port .';dbname=' . self::$db , self::$user , self::$pass );
	}
	
	public static function getInstance(){
		return self::$instance;
	}
}