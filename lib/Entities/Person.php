<?php
namespace Lib\Entities;

abstract class Person implements ISavable {
	public $id;
	public $name;
	public $img;

	function __construct($id, $name, $img) {
		$this->id = $id;
		$this->name = $name;
		$this->img = $img;
	}

	public function save(\PDO $db) {}
	public function edit(\PDO $db) {}
	public function delete(\PDO $db) {}
}