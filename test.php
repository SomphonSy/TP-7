<?php
$db = new SQLite3('database.db3');

$db->exec('CREATE TABLE foo (id INTEGER, bar STRING)');
$db->exec("INSERT INTO foo (id, bar) VALUES (1, 'Ceci est un test')");

$stmt = $db->prepare('SELECT * FROM user ');
var_dump($stmt);
$stmt->bindValue(':user', 1, SQLITE3_INTEGER);

$result = $stmt->execute();
?>