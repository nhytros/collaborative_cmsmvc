<?php defined('CORE') OR exit('No direct script access allowed');
class DB {
	private static $_instance = null;
	private $_pdo,
	$_query,
	$_result,
	$_error = false,
	$_lastInsertID = null,
	$_count = 0;

	private function __construct() {
		$charset = (config('dbchar')) ? ';charset='.config('dbchar') : '';
		$dsn = 'mysql:host='.config('dbhost').';dbname='.config('dbname').$charset;
		$options = [
			PDO::ATTR_PERSISTENT => TRUE,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_EMULATE_PREPARES => false,
		];
		// $charset = (Config::get('dbchar')) ? ';charset='.Config::get('dbchar') : '';
		try {
			$this->_pdo = new PDO($dsn,Config::get('dbuser'),Config::get('dbpass'),$options);
		} catch(PDOException $e) { die($e->getMessage()); }
	}

	public static function getInstance() {
		if (!isset(self::$_instance) || is_null(self::$_instance) || empty(self::$_instance)) {
			self::$_instance = new DB();
		}
		return self::$_instance;
	}

	public function query($sql, $params=[],$class=false) {
		$this->_error = false;
		if ($this->_query = $this->_pdo->prepare($sql)) {
			$x = 1;
			if (count($params)) {
				foreach ($params as $param) {
					$this->_query->bindValue($x, $param);
					$x++;
				}
			}
			if ($this->_query->execute()) {
				if($class) {
					$this->_result = $this->_query->fetchAll(PDO::FETCH_CLASS,$class);
				} else {
					$this->_result = $this->_query->fetchAll(PDO::FETCH_OBJ);
				}
				$this->_count = $this->_query->rowCount();
				$this->_lastInsertID = $this->_pdo->lastInsertId();
			} else {
				$this->_error = true;
			}
		}
		return $this;
	}

	public function action($action,$table,$where) {
		$where = (!is_array($where)) ? ['id','=',$where] : $where;
		if (count($where) === 3) {
			$operators = array('=','>','<','>=','<=');
			$field    = $where[0];
			$operator = $where[1];
			$value    = $where[2];
			if (in_array($operator,$operators)) {
				$sql = "{$action} FROM `{$table}` WHERE `{$field}` {$operator} ?";
				// vd($sql);
				if (!$this->query($sql,array($value))->error()) { return $this; }
			}
		}
		return false;
	}

	//public function select($table,$where) { return (!$this->query("SELECT * FROM {$table} WHERE id = {$id}")->error()) ? true : false; }
	public function get($table,$where) {
		$where = (!is_array($where)) ? ['id','=',$where] : $where;
		$fieldName  = $where[0];
		$operator   = $where[1];
		$fieldValue = $where[2];
		$sql = "SELECT * FROM {$table} WHERE {$fieldName} {$operator} '{$fieldValue}'";
		return(!$this->query($sql)->error()) ? $this->query($sql) : false;
	}

	public function insert($table, $fields=[]) {
		$fieldString = '';
		$valueString = '';
		$values = [];
		foreach ($fields as $field => $value) {
			$fieldString .= '`'.$field.'`, ';
			$valueString .= '?,';
			$values[] = $value;
		}
		$fieldString = rtrim($fieldString, ', ');
		$valueString = rtrim($valueString, ', ');
		$sql = "INSERT INTO {$table} ($fieldString) VALUES ({$valueString})";
		return (!$this->query($sql, $values)->error()) ? true : false;
	}

	public function update($table,$where,$fields=[]) {
		$where = (!is_array($where)) ? ['id','=',$where] : $where;
		$fieldName  = $where[0];
		$operator   = $where[1];
		$fieldvalue = $where[2];
		$fieldString = '';
		$values = [];
		foreach ($fields as $field => $value) {
			$fieldString .= ' '.$field.' = ?,';
			$values[] = $value;
		}
		$fieldString = trim($fieldString);
		$fieldString = rtrim($fieldString, ',');
		$sql = "UPDATE {$table} SET {$fieldString} WHERE {$fieldName} {$operator} {$fieldvalue}";
		return (!$this->query($sql, $values)->error()) ? true : false;
	}

	public function delete($table,$id) {
		return (!$this->query("DELETE FROM {$table} WHERE id = {$id}")->error()) ? true : false;
	}

	protected function _read($table, $params=[],$class) {
		$conditionString = '';
		$bind = [];
		$order = '';
		$limit = '';

		// Conditions
		if (isset($params['conditions'])) {
			if (is_array($params['conditions'])) {
				foreach ($params['conditions'] as $condition) {
					$conditionString .= ' '.$condition.' AND';
				}
				$conditionString = trim($conditionString);
				$conditionString = rtrim($conditionString, ' AND');
			} else {
				$conditionString = $params['conditions'];
			}
			if ($conditionString != '') $conditionString = ' WHERE '.$conditionString;
		}

		// Bind
		if (array_key_exists('bind', $params)) { $bind = $params['bind']; }

		// Order
		if (array_key_exists('order', $params)) { $order = ' ORDER BY '.$params['order']; }

		// Limit
		if (array_key_exists('limit', $params)) { $limit = ' LIMIT '.$params['limit']; }

		$sql = "SELECT * FROM {$table}{$conditionString}{$order}{$limit}";
		if ($this->query($sql, $bind,$class)) {
			return (!count($this->_result)) ? false : true;
		}
		return false;
	}

	public function find($table, $params=[],$class=false) {
		return ($this->_read($table, $params, $class)) ? $this->results() : false;
	}

	public function findFirst($table, $params=[],$class=false) {
		return ($this->_read($table, $params, $class)) ? $this->first() : false;
	}

	public function results() { return $this->_result; }
	public function   first() { return (!empty($this->results())) ? $this->results()[0] : []; }
	public function   error() { return $this->_error; }
	public function   count() { return $this->_count; }
	public function  lastID() { return $this->_lastInsertID; }
	public function get_columns($table) { return $this->query("SHOW COLUMNS FROM {$table}")->results(); }
}
