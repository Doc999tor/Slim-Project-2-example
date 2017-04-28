<?php
namespace Lib\Entities;

class Course implements ISavable {
	use SelectAll;
	public $id;
	public $name;
	public $description;
	public $img;
	private static $table_name = 'courses';

	function __construct($id, $name, $description, $img) {
		$this->id = $id;
		$this->name = $name;
		$this->description = $description;
		$this->img = $img;
	}

	public function save(\PDO $db) {
		$stmt = $db->prepare("where id = :course_id) LIMIT 1");
		$stmt->bindValue(':course_id', (int)$course_id, \PDO::PARAM_INT);
		$stmt->execute();

	}
	public function edit(\PDO $db) {
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