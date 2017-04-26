<?php

$admins = ['war', 'death', 'samael'];
$sqls = array_map(function ($admin) {
	return "UPDATE admins SET password = '" . password_hash($admin, PASSWORD_DEFAULT) . "' WHERE LOWER(name) = '{$admin}';";
}, $admins);

$conn = new mysqli('localhost', 'root', '', 'proj2');
array_walk($sqls, function ($sql) use ($conn) {
	echo $sql . "\n";
	$conn->query($sql);
});

