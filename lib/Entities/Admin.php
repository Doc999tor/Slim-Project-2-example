<?php
namespace Lib\Entities;

class Admin extends Person {
	use SelectAll;
	private static $table_name = 'admins';

	private $password;
	private $role_id;
	public $role_name;

	function __construct($id, $name, $img, $password = null, $role_id = null, $role_name = null) {
		parent::__construct($id, $name, $img);
		$this->password = $password;
		$this->role_id = $role_id;
		$this->role_name = $role_name;
	}

	public static function selectOne(\PDO $db, int $id) {
		$stmt = $db->prepare("
			SELECT a.id, a.name, a.image as img, a.password, a.role_id, r.name as role_name
			FROM admins a JOIN roles r ON a.role_id = r.id
			WHERE a.id = :id
		");
		$stmt->bindValue(':id', (int)$id, \PDO::PARAM_INT);
		$stmt->execute();

		return new self(...$stmt->fetch(\PDO::FETCH_NUM));

	}

}