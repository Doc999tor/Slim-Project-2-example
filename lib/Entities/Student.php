<?php
namespace Lib\Entities;

class Student extends Person {
	use SelectAll;
	private static $table_name = 'students';

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