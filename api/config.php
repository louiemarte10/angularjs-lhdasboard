<?php


require("/var/www/html/config/pipeline-x.php");
class pipe_db {
	protected static $pipe_db;
	protected static $db_write;
	private static $active_db;
	private static $insert_id;
	private static $affected_rows;

	static function query($sql, $conn = 'auto'){
		if ($conn != 'write' && preg_match("/^[^a-zA-Z]*?(SELECT|select)/", $sql)) self::init_db('read'); // IF READ
		else self::init_db('write');

		if (preg_match("/^[^a-zA-Z]*?(SELECT|select)/", $sql)) $sql = preg_replace("/^\s+/m", "", $sql);

		$res = self::$active_db->query($sql);
		self::$insert_id = self::$active_db->insert_id;
		self::$affected_rows = self::$active_db->affected_rows;
		if (self::$active_db->errno) trigger_error(self::$active_db->error, E_USER_ERROR);
		return $res;
	}

	static function cached_query($sql){
		$sql_checksum = md5($sql);
		if (empty($_SESSION["query_cache_{$sql_checksum}"])):
			$res = self::query($sql);
			while ($row = $res->fetch_assoc()) $_SESSION["query_cache_{$sql_checksum}"][] = $row;
		endif;
		return new db_cached_result($_SESSION["query_cache_{$sql_checksum}"]);
	}

	static function query_debug($sql, $exit = true){
		$trace = end(debug_backtrace());
		echo "<pre>SQL Debug: <b>{$trace['file']}</b> on line <b>{$trace['line']}</b>\n{$sql}</pre>";
		if ($exit) exit();
	}

	static function affected_rows(){
		return self::$affected_rows;
	}

	static function insert_id(){
		return self::$insert_id;
	}

	static function real_escape_string($str){
		return self::$active_db->real_escape_string($str);
	}

	static function set_charset($str) {
		// self::$pipe_db->set_charset($str);
		return self::$active_db;
	}
	
	static function init_db($type){
		if ($type == 'read'):
			if (!method_exists(self::$pipe_db, "query")):
				self::$pipe_db = @new MySQLi(config::get_server_by_user('pipe'), 'app_pipe', config::get_db_user_password('pipe'), 'callbox_pipeline2');
			endif;

			self::$active_db = &self::$pipe_db;
		else:
			if (!method_exists(self::$db_write, "query")): // SEND TO MASTER IF WRITE
				self::$db_write = @new MySQLi(config::get_server_by_name('master'), 'app_pipe', config::get_db_user_password('pipe'), 'callbox_pipeline2');
			endif;

			self::$active_db = &self::$db_write;
		endif;

		if (self::$active_db->connect_error) trigger_error(self::$active_db->connect_error, E_USER_ERROR);

		self::$active_db->set_charset("utf8");
	}

}
class smm_db {
	protected static $pipe_db;
	protected static $db_write;
	private static $active_db;
	private static $insert_id;
	private static $affected_rows;

	static function query($sql, $conn = 'auto'){
		if ($conn != 'write' && preg_match("/^[^a-zA-Z]*?(SELECT|select)/", $sql)) self::init_db('read'); // IF READ
		else self::init_db('write');
		

		if (preg_match("/^[^a-zA-Z]*?(SELECT|select)/", $sql)) $sql = preg_replace("/^\s+/m", "", $sql);
		
		$res = self::$active_db->query($sql);
		self::$insert_id = self::$active_db->insert_id;
		self::$affected_rows = self::$active_db->affected_rows;
		
		if (self::$active_db->errno) trigger_error(self::$active_db->error.", sql=". $sql, E_USER_ERROR);
		return $res;
	}

	static function cached_query($sql){
		$sql_checksum = md5($sql);
		if (empty($_SESSION["query_cache_{$sql_checksum}"])):
			$res = self::query($sql);
			while ($row = $res->fetch_assoc()) $_SESSION["query_cache_{$sql_checksum}"][] = $row;
		endif;
		return new db_cached_result($_SESSION["query_cache_{$sql_checksum}"]);
	}

	static function query_debug($sql, $exit = true){
		$trace = end(debug_backtrace());
		echo "<pre>SQL Debug: <b>{$trace['file']}</b> on line <b>{$trace['line']}</b>\n{$sql}</pre>";
		if ($exit) exit();
	}

	static function affected_rows(){
		return self::$affected_rows;
	}
	static function getDb(){
		return self::$pipe_db;
	}
	static function getError(){
		return mysqli_error(self::$pipe_db) ;
	}

	static function insert_id(){
		return self::$insert_id;
	}

	static function real_escape_string($str){
		return self::$active_db->real_escape_string($str);
	}
	static function set_charset(){
		return self::$active_db->set_charset("utf8");
	}
		// $db_mailer_data = new MySQLi("192.168.50.47", "app_pipe", "a33-pipe", "callbox_mailer_data");
	
	static function init_db($type){
		if ($type == 'read'):
			if (!method_exists(self::$pipe_db, "query")):
				self::$pipe_db = @new MySQLi(config::get_server_by_user('smm'), 'app_pipe', config::get_db_user_password('pipe'), 'linkedhelper');
				mysqli_set_charset(self::$pipe_db, "utf8");
			endif;

			self::$active_db = &self::$pipe_db;
		else:
			if (!method_exists(self::$db_write, "query")): // SEND TO MASTER IF WRITE
				self::$db_write = @new MySQLi(config::get_server_by_name('smm_mktg'), 'app_pipe', config::get_db_user_password('pipe'), 'linkedhelper');
				mysqli_set_charset(self::$db_write, "utf8");
				
			endif;

			self::$active_db = &self::$db_write;
		endif;

		if (self::$active_db->connect_error) trigger_error(self::$active_db->connect_error, E_USER_ERROR);
	}

}
