<?php

require "../config.php";

$conn = new PDO('mysql:host='.DB_HOST.';dbname='. DB_DB, DB_USER, DB_PASS);

class User{
    
    private $id;
    private $email;
    private $pass;
    private $username;
    
    
    //METHODS
    public function __construct($username="", $pass="", $email=""){
        
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
        }else{
            $stmt = $conn->prepare('UPDATE user SET username=:username, email=:email, hashed_password=:pass WHERE id=:id');
            $result = $stmt->execute(
                    [
                        'id'=>$this->id,
                        'username' => $this->username,
                        'email' => $this->email,
                        'pass'=> $this->pass
                    ]
                    );
            if($result === true){
                return true;
            }
        }
        return false;
    }
    
    static public function loadUserById(PDO $conn, $id)
    {
        $stmt = $conn->prepare('SELECT * FROM user WHERE id=:id');
        $result = $stmt->execute(['id' => $id]);
        
        if ($result === true && $stmt->rowCount() > 0){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $loadedUser = new User();
            $loadedUser->id = $row['id'];
            $loadedUser->username = $row['username'];
            $loadedUser->pass = $row['hashed_password'];
            $loadedUser->email = $row['email'];
            
            return $loadedUser;
        }
        return null;
    }
    
    static public function loadAllUsers(PDO $conn)
    {
        $sql = 'SELECT * FROM user';
        $ret = [];
        
        $result = $conn->query($sql);
        if($result !== false && $result->rowCount() != 0){
            foreach($result as $row){
                $loadedUser = new User();
                $loadedUser->id = $row['id'];
                $loadedUser->username = $row['username'];
                $loadedUser->pass = $row['hashed_password'];
                $loadedUser->email = $row['email'];
                
                $ret[] = $loadedUser;
            }
            
        }
        return $ret;
    }
    
    public function delete(PDO $conn)
    {
        if($this->id != -1){
            $stmt = $conn->prepare('DELETE FROM user WHERE id=:id');
            $result = $stmt->execute(['id'=> $this->id]);
            
            if($result === true){
                $this->id = -1;
                
                return true;
            }
            return false;
        }
        return true;
    }


    //GETTERS
    
    public function getId() {
        return $this->id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPass() {
        return $this->pass;
    }
    
    public function getUsername(){
        return $this->username;
    }

    //SETTERS
    
    public function setId($id) {
        $this->id = $id;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPass($newPass) {
        
        $hashedPass = password_hash($newPass, PASSWORD_BCRYPT);
        $this->pass = $hashedPass;
    }
    
    public function setUsername($username){
        $this->username = $username;
    }


}


