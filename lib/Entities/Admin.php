<?php
namespace Lib\Entities;

use \Psr\Http\Message\UploadedFileInterface as UploadedFile;

class Admin extends Person {
	use SelectAll;
	private static $table_name = 'admins';

	private $password;
	private $role_id;
	public $role_name;

	private static $permissions = [
		"owner" => ["id" => 1],
		"manager" => ["id" => 2],
		"sales" => ["id" => 3],
	];
	private static function getOwner() {return self::$permissions['owner'];}
	private static function getManager() {return self::$permissions['manager'];}
	private static function getSales() {return self::$permissions['sales'];}

	function __construct($id, $name, $img = null, $password = null, $role_id = null, $role_name = null) {
		parent::__construct($id, $name, $img);
		$this->password = $password;
		$this->role_id = $role_id;
		$this->role_name = $role_name;
	}

	public function save(\PDO $db, UploadedFile $newFile) {
		$this->saveImage($newFile);

		$stmt = $db->prepare("INSERT INTO " . self::$table_name . " VALUES (NULL, :name, :img, :password, :role_id)");
		$stmt->bindValue(':name', (string)$this->name, \PDO::PARAM_STR);
		$stmt->bindValue(':role_id', (int)$this->role_id, \PDO::PARAM_INT);
		$stmt->bindValue(':password', password_hash((string)$this->password, PASSWORD_DEFAULT), \PDO::PARAM_STR);
		$stmt->bindValue(':img', (string)$newFile->getClientFilename(), \PDO::PARAM_STR);

		$stmt->execute();
	}
	public function edit(\PDO $db, UploadedFile $newFile) {
		$stmt = $db->prepare("where id = :course_id) LIMIT 1");
		$stmt->bindValue(':course_id', (int)$course_id, \PDO::PARAM_INT);
		$stmt->execute();
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

	public static function getRoles(\PDO $db) {
	    $result = $db->query("SELECT * FROM roles LIMIT 1000");
	    $rows = [];
	    while ($row = $result->fetch(\PDO::FETCH_OBJ)) {
	        $rows []= $row;
	    }
	    return $rows;
	}

	public static function getRolesForAdminCreation(\PDO $db) {
		return array_filter(self::getRoles($db), function ($role) {
			return $role->id != self::getOwner()['id'];
		});
	}

	public static function checkPassword(\PDO $db, $name, $password) {
		$stmt = $db->prepare("
			SELECT null as id, a.name, a.image, a.password as hash, null as role_id, r.name as role FROM " . self::$table_name . " a
			JOIN roles r on a.role_id = r.id
			WHERE LOWER(a.name) = LOWER(:name) LIMIT 1
		");
		$stmt->bindValue(':name', (string)$name, \PDO::PARAM_STR);
		$stmt->execute();

		$row = $stmt->fetch(\PDO::FETCH_OBJ);
		if (password_verify(strtolower($password), $row->hash)) {
			return new self(...array_values(get_object_vars($row)));
		} else {
			return false;
		}
	}
}