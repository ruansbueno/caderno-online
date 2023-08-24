<?php 

	class MySQL
	{
		private static $pdo;
		public static function connect(){
			if(isset(self::$pdo)){
				return self::$pdo;
			}else{
				try{
					self::$pdo = new \PDO('mysql:host=localhost;dbname='.DB_NAME,DB_USER, DB_PASS,array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
					self::$pdo->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
				}catch(Exception $e){
					echo '<h1>Erro ao conectar</h1>';
					die();
				}
				return self::$pdo;
			}
		}
	}