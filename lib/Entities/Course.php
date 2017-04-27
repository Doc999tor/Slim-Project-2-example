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

	public function save() {}
	public function edit() {}
	public function delete() {}
}