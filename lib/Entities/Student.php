<?php
namespace Lib\Entities;

class Student extends Person {
	use SelectAll;
	private static $table_name = 'students';
}