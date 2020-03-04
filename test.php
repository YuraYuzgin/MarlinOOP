<?php

require 'Database.php';

$query = new Database;

$result = $query->getAll('test');
//$result = $query->getOne('test', 2);
//$result = $query->insert('test', ['name' => 'Olga', 'comments' => 'text']);
//$result = $query->update('test', ['comments' => 'new text'], 1);
//$result = $query->delete('test', 5);
var_dump($result);

?>