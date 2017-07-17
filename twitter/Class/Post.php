<?php

require "../config.php";


$conn = new PDO('mysql:host='.DB_HOST.';dbname='. DB_DB, DB_USER, DB_PASS);

class Post{
    
    private $id;
    private $userId;
    private $content;
    private $creationDate;
    
    //methods
    
    public function __construct() {
        $this->id = -1;
        $this->userId = 0;
        $this->content = "";
        $this->creationDate = "";
    }
    
    static public function loadPostById(PDO $conn, $id)
    {
        $stmt = $conn->prepare('SELECT * FROM post WHERE id=:id');
        $result = $stmt->execute(['id' => $id]);
        
        if ($result === true && $stmt->rowCount()>0){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $loadedPost = new Post();
            $loadedPost->id = $row['id'];
            $loadedPost->userId = $row['user_id'];
            $loadedPost->content = $row['content'];
            $loadedPost->creationDate = $row['creation_date'];
            
            return $loadedPost;
            
        }
        
        return NULL;
    }
    
    static public function loadAllPosts(PDO $conn)
    {
        $sql = 'SELECT * FROM post';
        $ret = [];
        
        $result = $conn->query($sql);
        if ($result !== false && $result->rowCount()>0){
            foreach($result as $row){
            $loadedPost = new Post;
            $loadedPost->id = $row['id'];
            $loadedPost->userId = $row['user_id'];
            $loadedPost->content = $row['content'];
            $loadedPost->creation_date = $row['creation_date'];
            
             $ret[] = $loadedPost;
            }
        }
        
        
        return $ret;
    }
    
    public function saveToDB(PDO $conn){
    
         if($this->id == -1){
            $sql = 'INSERT INTO post(content, creation_date, user_id) VALUES (:content, :creation_date, :user_id)';
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute(
                    ['content' => $this->getContent(), 
                     'creation_date' => $this->getCreationDate(), 
                     'user_id' => $this->getUserId()
                    ]);
            if($result === true){
                $this->id = $conn->lastInsertId();
                return true;
            }
        }else{
            $sql = 'UPDATE post SET user_id=:user_id, content=:content,creation_date=:creation_date WHERE id=:id';
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute
                    ([
                        'content' => $this->getContent(),
                        'creation_date' => $this->getCreationDate(),
                        'id' => $this->getId(),
                        'user_id' => $this->getUserId()
                    ]);
            if($result === true){
                return true;
                
            }
        }
        echo "raz";
        return false;
    }
   
    //getters
    
    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getContent() {
        return $this->content;
    }

    public function getCreationDate() {
        return $this->creationDate;
    }

    
    //setters
    
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
        return $this;
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    public function setCreationDate() {
        $format = "d M Y H:i:s";
        $this->creationDate = date($format, time());
        return $this;
    }


    
}


$newPost = new Post();
$newPost->setContent("działaj w końcu...");
$newPost->setCreationDate();
$newPost->setUserId(1);

var_dump($newPost->saveToDB($conn));
var_dump($newPost);