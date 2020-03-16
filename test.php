<?php

//require_once 'Database.php';

//$users = Database::getInstance()->query("SELECT * FROM users WHERE username IN (?, ?)", ['John Doe', 'Jane Koe']);
//$users = Database::getInstance()->get('users', ['username', '=','John Doe']);
//$users = Database::getInstance()->delete('users', ['username', '=','Jane Koe']);

/*Database::getInstance()->update('users', 5, [
    'username' => 'Aldous Huxley',
    'password' => 'newpassword'
]);*/

//$users = Database::getInstance()->get('users', ['username', '=','John Doe']);
//echo $users->first()->username;


/*if($users->error()) {
    echo 'we have an error';
} else {
    foreach ($users->results() as $user) {
        echo $user->username . '<br>';
    }
}*/


//$query = new Database;

//$result = $query->getAll('test');
//$result = $query->getOne('test', 2);
//$query->insert('test', ['name' => 'Olga', 'comments' => 'text']);
//$query->update('test', ['comments' => 'new text'], 1);
//$query->delete('test', 5);
//var_dump($result);

?>