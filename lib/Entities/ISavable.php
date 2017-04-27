<?php
namespace Lib\Entities;

interface ISavable {
	public function save();
	public function edit();
	public function delete();

	public static function selectAll(\PDO $db);
}