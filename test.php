<?php

require 'Database.php';

$query = new Database;

$result = $query->getAll('test');
//$result = $query->getOne('test', 2);
//$query->insert('test', ['name' => 'Olga', 'comments' => 'text']);
//$query->update('test', ['comments' => 'new text'], 1);
//$query->delete('test', 5);
var_dump($result);

?>