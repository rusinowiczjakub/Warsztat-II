<?php

require "../config.php";

$conn = new PDO('mysql:host='.DB_HOST.';dbname='. DB_DB, DB_USER, DB_PASS);

class User{
    
    private $id;
    private $email;
    private $pass;
    private $username;
    
    
    //METHODS
    public function __construct($username, $pass, $email){
        
        $this->id = -1;
        $this->setEmail($email);
        $this->setUsername($username);
        $this->setPass($pass);
           
    }
    
    public function saveToDB(PDO $conn)
    {
        if($this->id == -1){
            $stmt = $conn->prepare('INSERT INTO user(email, hashed_password, username) VALUES (:email, :pass, :username)');
            $result = $stmt->execute(['email' => $this->email, 'pass' => $this->pass, 'username' => $this->username]);
            
            if($result !== false){
                $this->id = $conn->lastInsertId();
                
                return true;
            }
        }
        return false;
    }
    
    //GETTERS
    
    function getId() {
        return $this->id;
    }

    function getEmail() {
        return $this->email;
    }

    function getPass() {
        return $this->pass;
    }

    //SETTERS
    
    function setId($id) {
        $this->id = $id;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setPass($newPass) {
        
        $hashedPass = password_hash($newPass, PASSWORD_BCRYPT);
        $this->pass = $hashedPass;
    }
    
    function setUsername($username){
        $this->username = $username;
    }


}

var_dump($user1 = new User("Bobik", "haslo123", "costam@cos.pl"));
var_dump($user1->saveToDB($conn));

var_dump($user2 = new User("razdwa", "haslohaslo", "email@email.pl"));
var_dump($user2->saveToDB($conn));

var_dump($user3 = new User("razdwatrzy", "haslohaslo2", "email2@email.pl"));
var_dump($user3->saveToDB($conn));

var_dump($user4 = new User("razdwatrzycztery", "haslohaslo21", "email23@email.pl"));
var_dump($user4->saveToDB($conn));
