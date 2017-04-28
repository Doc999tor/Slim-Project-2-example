<?php
namespace Lib\Entities;

interface ISavable {
	public function save(\PDO $db);
	public function edit(\PDO $db);
	public function delete(\PDO $db);

	public static function selectAll(\PDO $db);
}