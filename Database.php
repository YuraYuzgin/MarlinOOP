<?php

class Database
{

    public $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=localhost;dbname=marlin_oop_db', 'root', '');
    }

    public function getAll($table)
    {
        $sql = "SELECT * FROM $table";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getOne($table, $id)
    {
        $sql = "SELECT * FROM $table WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([':id' => $id]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function insert($table, $data)
    {
        // создаём строки из массива для запроса
        $keys = array_keys($data);
        $fieldNameString = implode($keys, ', ');
        $placeholderString = implode($keys, ', :');
        $placeholderString = ':' . $placeholderString;

        // выполняем запрос
        $sql = "INSERT INTO $table ($fieldNameString) VALUES ($placeholderString)";
        $statement = $this->pdo->prepare($sql);
        $statement->execute($data);
    }

    public function update($table, $data, $id)
    {
        // создаём строку из массива для запроса
        foreach ($data as $key => $value) {
            $string .= $key . ' = :' . $key . ', ';
        }
        $string = rtrim($string, ', ');

        // добавляем к массив id
        $data['id'] = $id;

        // выполняем запрос
        $sql = "UPDATE $table SET $string WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute($data);
    }

    public function delete($table, $id)
    {
        $sql = "DELETE FROM $table WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([':id' => $id]);
    }
}