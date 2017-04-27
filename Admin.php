<?php
namespace Lib\Entities;

class Admin extends Person {
	public $password;
	private static $table_name = 'admins';
	function __construct($id, $name, $password, $img) {
		parent::__construct($id, $name, $img);
		$this->password = $password;
	}
	public static function selectAll(\PDO $db) {

	}
}