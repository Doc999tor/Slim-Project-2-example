<?php
namespace Lib\Entities;

trait SelectAll {
	public static function selectAll(\PDO $db) {
		$result = $db->query("SELECT * from " . self::$table_name . " limit 1000");
		$rows = [];
		while ($row = $result->fetch(\PDO::FETCH_NUM)) {
			$rows []= new self(...$row);
		}
		return $rows;
	}
}