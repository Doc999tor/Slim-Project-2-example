<?php
namespace Lib\Entities;

use \Psr\Http\Message\UploadedFileInterface as UploadedFile;

class Course implements ISavable {
	use SelectAll;
	public $id;
	public $name;
	public $description;
	public $img;
	private static $table_name = 'courses';

	function __construct($id, $name, $description, $img = null) {
		$this->id = $id;
		$this->name = $name;
		$this->description = $description;
		$this->img = $img;
	}

	public function save(\PDO $db, UploadedFile $newFile) {
		$this->saveImage($newFile);

		$stmt = $db->prepare("INSERT INTO " . self::$table_name . " VALUES (NULL, :name, :description, :img)");
		$stmt->bindValue(':name', (string)$this->name, \PDO::PARAM_STR);
		$stmt->bindValue(':description', (string)$this->description, \PDO::PARAM_STR);
		$stmt->bindValue(':img', (string)$newFile->getClientFilename(), \PDO::PARAM_STR);
		$stmt->execute();

	}
	public function edit(\PDO $db, UploadedFile $newFile) {
		$stmt = $db->prepare("where id = :course_id) LIMIT 1");
		$stmt->bindValue(':course_id', (int)$course_id, \PDO::PARAM_INT);
		$stmt->execute();
	}

	public function delete(\PDO $db) {
		$stmt = $db->prepare("where id = :course_id) LIMIT 1");
		$stmt->bindValue(':course_id', (int)$course_id, \PDO::PARAM_INT);
		$stmt->execute();

	}

	public static function selectByStudent(\PDO $db, int $student_id): self {
		$stmt = $db->prepare("SELECT * FROM courses WHERE id = (select course_id from students where id = :student_id) LIMIT 1");
		$stmt->bindValue(':student_id', (int)$student_id, \PDO::PARAM_INT);
		$stmt->execute();

		return new self(...$stmt->fetch(\PDO::FETCH_NUM));
	}
}