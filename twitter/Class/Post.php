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
        $this->id = NULL;
        $this->setUserId(null);
        $this->setContent('');
        $this->setCreationDate(null);
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
    
        if($this->id !== null){
            $sql = 'UPDATE post SET content=:content, user_id=:user_id, creation_date=:creation_date WHERE id=:id';
            
            $stmt = $conn->prepare($sql);
            
            $result = $stmt->execute(
                    [
                        'id' => $this->getId(),
                        'user_id' => $this->getUserId(),
                        'content'=> $this->getContent(),
                        'creation_date' => $this->getCreationDate()
                        
                    ]);
            if($result == true){
                return true;
            }
                                
            }else{
                $sql = 'INSERT INTO post(user_id, content, creation_date) VALUES (:user_id, :content, :creation_date)';
                $stmt = $conn->prepare($sql);
                $result = $stmt->execute(
                        [
                            'user_id' => $this->getUserId(),
                            'content' => $this->getContent(),
                            'creation_date' => $this->getCreationDate()
                            
                        ]);
                
                if($result == true){
                    $this->id = $conn->lastInsertId();
                    return true;
                }
            }
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


$testPost = new Post();
$testPost->setContent("zapisz sie kurna");
$testPost->setCreationDate();
$testPost->setUserId(1);

var_dump($testPost->saveToDB($conn));