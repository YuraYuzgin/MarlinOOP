<?php

class Database
{
    private static $instance = null;
    private $pdo, $query, $error = false, $results, $count;

    public function __construct()
    {
        try{
            $this->pdo = new PDO("mysql:host=" . Config::get('mysql.host') . ";dbname=" . Config::get('mysql.database'), Config::get('mysql.username'), Config::get('mysql.password'));
        } catch (PDOException $exception) {
            die($exception->getMessage());
        }
        
    }

    public static function getInstance()
    {
        if(!isset(self::$instance)) {
            self::$instance = new Database;
        }
        return self::$instance;
    }

    public function query($sql, $params = [])
    {
        $this->error = false;
        $this->query = $this->pdo->prepare($sql);

        if(count($params)) {
            $i = 1;
            foreach ($params as $param) {
                $this->query->bindValue($i, $param);
                $i++;
            }
        }

        if(!$this->query->execute()) {
            $this->error = true;
        } else {
            $this->results = $this->query->fetchAll(PDO::FETCH_OBJ);
            $this->count = $this->query->rowCount();
        }
        
        
        return $this;
    }

    public function error()
    {
        return $this->error;
    }

    public function results()
    {
        return $this->results;
    }

    public function count()
    {
        return $this->count;
    }

    public function get($table, $where = [])
    {
        return $this->action('SELECT *', $table, $where);
    }

    public function delete($table, $where = [])
    {
        return $this->action('DELETE', $table, $where);
    }

    public function action($action, $table, $where = [])
    {
        if(count($where) === 3) {

            $operators = ['=', '>', '<', '>=', '<='];

            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];

            if(in_array($operator, $operators)) {

                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
                if(!$this->query($sql, [$value])->error()) {
                    return $this;
                }
            }
        }

        return false;
    }

    public function insert($table, $fields = [])
    {
        $values = '';
        foreach ($fields as $field) {
            $values .= "?,";
        }
        $values = rtrim($values, ',');

        $sql = "INSERT INTO {$table} (`" . implode('`, `',array_keys($fields)) . "`) VALUES (" . $values . ")";

        if(!$this->query($sql, $fields)->error()) {
            return true;
        }

        return false;
    }

    public function update($table, $id, $fields = [])
    {
        $set = '';
        foreach ($fields as $key => $field) {
            $set .= "{$key} = ?,";
        }

        $set = rtrim($set, ',');

        $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";

        if(!$this->query($sql, $fields)->error()) {
            return true;
        }

        return false;
    }

    public function first()
    {
        return $this->results()[0];
    }




    /*
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
        // создаём строки из массива для запроса (перечисление полей и плэйсхолдеров)
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

        // добавляем к массиву id
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
    */
}