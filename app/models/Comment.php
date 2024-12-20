<?php

class Comment{
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function getCommentsByPostsId($post_id){
        $this->db->query('SELECT * FROM comments WHERE posts_id = :post_id AND deleted_at IS NULL');
        $this->db->bind(':post_id', $post_id);

        $results = $this->db->resultSet();
        return $results;

    }


    public function countCommentsTable(){
        $this->db->query('SELECT * FROM comments WHERE deleted_at IS NULL');
        $results = $this->db->rowCount();
        return $results;

    }

    public function countCommentsByPostsId($post_id){  
        $this->db->query('SELECT * FROM comments WHERE posts_id = :post_id AND deleted_at IS NULL');
        $this->db->bind(':post_id', $post_id);
        $results = $this->db->rowCount();
        return $results;
    }

    public function countCommentsByUsersId($user_id){  
        $this->db->query('SELECT * FROM comments WHERE user_id = :user_id AND deleted_at IS NULL');
        $this->db->bind(':post_id', $user_id);
        $results = $this->db->rowCount();
        return $results;
    }


    public function getCommentsByPostId($id){
        if (is_int($id)) {
            $this->db->query('SELECT * FROM comments WHERE posts_id = :post_id AND deleted_at IS NULL');
            $this->db->bind(':post_id', $id);
        }
        
        $row = $this->db->resultSet();
        return $row;
    }


    public function createComment($data = array()){
        
        $this->db->query('INSERT INTO comments (users_id, posts_id, content, name, email, website) VALUES (:users_id, :posts_id, :content, :name, :email, :website)');
        $this->db->bind(':users_id', $data['users_id']);
        $this->db->bind(':posts_id', $data['posts_id']);
        $this->db->bind(':content', $data['content']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':website', $data['website']);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

}
?>