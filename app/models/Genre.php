<?php

class Genre{
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function getAllGenre(){
        $this->db->query('SELECT * FROM genres WHERE deleted_at IS NULL ORDER BY title ASC');

        $results = $this->db->resultSet();
        return $results;
    }

    public function getGenreById($id){
        $this->db->query('SELECT * FROM genres WHERE id = :id AND deleted_at IS NULL');
        $this->db->bind(':id', $id);
        $results = $this->db->single();
        return $results;
    }

    public function getGenreByTitle($title){

        $this->db->query('SELECT * FROM genres WHERE title = :title AND deleted_at IS NULL');
        $this->db->bind(':title', $title);
        $results = $this->db->single();
        return $results;
        
    }

    public function getGenreAndPostsCount($range = 5){

        $this->db->query('SELECT genre_id,
                        COUNT(genre_id) AS counts,
                        genres.*
                        FROM posts 	
                        INNER JOIN genres
                        on genre_id = genres.id
                        WHERE posts.deleted_at IS NULL AND genres.deleted_at IS NULL  
                        GROUP BY genre_id 
                        ORDER BY counts DESC LIMIT 0, :range');

        $this->db->bind(':range', $range);
        $results = $this->db->resultSet();
        return $results;

    }

    public function getGenreByPostId($post_id){

        $this->db->query('SELECT genres.*
        FROM posts 	
        INNER JOIN genres
        on genre_id = genres.id
        WHERE posts.id = :post_id AND posts.deleted_at IS NULL AND genres.deleted_at IS NULL');

        $this->db->bind(':post_id', $post_id);
        $results = $this->db->single();
        return $results;

    }


    public function getAllGenreAndPostAlpha(){

        $this->db->query('SELECT genre_id,
        COUNT(genre_id) AS counts,
        genres.*
        FROM posts 	
        INNER JOIN genres
        on genre_id = genres.id
        WHERE posts.deleted_at IS NULL AND genres.deleted_at IS NULL  
        GROUP BY genre_id 
        ORDER BY genres.title ASC');

        $results = $this->db->resultSet();
        return $results;


    }

    
}
?>