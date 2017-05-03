<?php
namespace Lib\Entities;

use \Psr\Http\Message\UploadedFileInterface as UploadedFile;

abstract class Person implements ISavable {
	public $id;
	public $name;
	public $img;

	function __construct($id, $name, $img = null) {
		$this->id = $id;
		$this->name = $name;
		$this->img = $img;
	}

	public function save(\PDO $db, UploadedFile $newFile) {}
	public function edit(\PDO $db, UploadedFile $newFile) {}
	public function delete(\PDO $db) {}
}