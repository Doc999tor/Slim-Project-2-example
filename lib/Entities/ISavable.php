<?php
namespace Lib\Entities;

use \Psr\Http\Message\UploadedFileInterface as UploadedFile;

interface ISavable {
	public function save(\PDO $db, UploadedFile $newFile);
	public function edit(\PDO $db, UploadedFile $newFile);
	public function delete(\PDO $db);

	public static function selectAll(\PDO $db);
}