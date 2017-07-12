<?php

require "../config.php";

class Post{
    
    private $id;
    private $userId;
    private $content;
    private $creationDate;
    
    //methods
    
    public function __construct() {
        $this->id($id);
        $this->userId($userId);
        $this->content($content);
        $this->creationDate($creationDate);
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

    public function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
        return $this;
    }


    
}
