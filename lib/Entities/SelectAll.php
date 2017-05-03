<?php
namespace Lib\Entities;

use \Psr\Http\Message\UploadedFileInterface as UploadedFile;

trait SelectAll {
	public static function selectAll(\PDO $db):array {
		$result = $db->query("SELECT * FROM " . self::$table_name . " LIMIT 1000");
		$rows = [];
		while ($row = $result->fetch(\PDO::FETCH_NUM)) {
			$rows []= new self(...$row);
		}
		return $rows;
	}
	public static function selectOne(\PDO $db, int $id): self {
		$stmt = $db->prepare("SELECT * FROM " . self::$table_name . " WHERE id = :id LIMIT 1");
		$stmt->bindValue(':id', (int)$id, \PDO::PARAM_INT);
		$stmt->execute();

		return new self(...$stmt->fetch(\PDO::FETCH_NUM));
	}

	protected function saveImage(UploadedFile $newFile) {
		$newFile->moveTo("public/" . self::$table_name . "/img/{$newFile->getClientFilename()}");
	}
}