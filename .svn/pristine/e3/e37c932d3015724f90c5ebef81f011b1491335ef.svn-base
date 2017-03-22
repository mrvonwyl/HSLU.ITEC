<?php
class database{
	
	private static $dbHost			= 'remote-mysql3.servage.net';		//localhost";
	private static $dbName			= 'extern1';						//transfer";
	private static $dbUsername		= 'extern1';						//"root";
	private static $dbUserPassword 	= '9NVDqzkVfcSHmsY2';				//"";

	private static $con = null;

	public function __construct(){
		die('Init function is not allowed!');
	}

	public static function connect(){
		$pdo = self::$con;
		if ( null == $pdo ){
			try{
				$pdo = new PDO("mysql:host=" . self::$dbHost . ";" . "dbname=" . self::$dbName, self::$dbUsername, self::$dbUserPassword);
				$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				self::$con = $pdo;
			}
			catch(PDOException $e){
				die($e->getMessage());
			}
		}
		return self::$con;
	}

	public static function disconnect()
	{
		self::$con = null;
	}
}
?>
