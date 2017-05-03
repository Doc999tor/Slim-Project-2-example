<?php
namespace Lib\Entities;

use \Psr\Http\Message\UploadedFileInterface as UploadedFile;

class Student extends Person {
	use SelectAll;
	private static $table_name = 'students';

	public $course_id;

	function __construct($id, $name, $course_id, $img = null) {
		parent::__construct($id, $name, $img);
		$this->course_id = $course_id;
	}

	public function save(\PDO $db, UploadedFile $newFile) {
		$this->saveImage($newFile);

		$stmt = $db->prepare("INSERT INTO " . self::$table_name . " VALUES (NULL, :name, :course_id, :img)");
		$stmt->bindValue(':name', (string)$this->name, \PDO::PARAM_STR);
		$stmt->bindValue(':course_id', (int)$this->course_id, \PDO::PARAM_INT);
		$stmt->bindValue(':img', (string)$newFile->getClientFilename(), \PDO::PARAM_STR);

		$stmt->execute();
	}
	public function edit(\PDO $db, UploadedFile $newFile) {
		$stmt = $db->prepare("where id = :course_id) LIMIT 1");
		$stmt->bindValue(':course_id', (int)$course_id, \PDO::PARAM_INT);
		$stmt->execute();
	}

	public static function selectByCourse(\PDO $db, int $course_id):array {
		$stmt = $db->prepare("SELECT * from " . self::$table_name . " WHERE course_id = :course_id LIMIT 1000");
		$stmt->bindValue(':course_id', (int)$course_id, \PDO::PARAM_INT);
		$stmt->execute();

		$rows = [];
		while ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
			$rows []= new self(...$row);
		}
		return $rows;
	}

	public static function countByCourse(\PDO $db, int $course_id): int {
		$stmt = $db->prepare("SELECT count(*) as count FROM " . self::$table_name . " WHERE course_id = :course_id LIMIT 1");
		$stmt->bindValue(':course_id', (int)$course_id, \PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetch(\PDO::FETCH_OBJ)->count;
	}
}