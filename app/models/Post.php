<?php

class Post{
    private $db;

    public function __construct(){
        $this->db = new Database;
    }



    public function createPost($data){
        $this->db->query('INSERT INTO posts (user_id, title, description, cover_name, mix_name, mix_type, genre_id, tracklist) VALUES (:user_id, :title, :description, :cover_name, :mix_name, :mix_type, :genre_id, :tracklist)');
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':cover_name', $data['cover_name']);
        $this->db->bind(':mix_name', $data['mix_name']);
        $this->db->bind(':mix_type', $data['mix_type']);
        $this->db->bind(':genre_id', $data['genre_id']);
        $this->db->bind(':tracklist', $data['tracklist']);
        

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }

    }


    public function deletePost($id){
        $this->db->query('UPDATE posts SET deleted_at = NOW()  WHERE id = :id');
        $this->db->bind(':id', $id);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }

    }


    public function lastRow(){
        return $this->db->last();
    }

    public function getPosts(){
        $this->db->query('SELECT * FROM posts WHERE deleted_at IS NULL');
        $results = $this->db->resultSet();
        return $results;
    }

    public function getPostsCount(){
        $this->db->query('SELECT * FROM posts WHERE deleted_at IS NULL');
        $results = $this->db->rowCount();
        return $results;
    }

    public function getUserPostsCount($user_id){
        $this->db->query('SELECT * FROM posts WHERE user_id = :user_id AND deleted_at IS NULL');
        $this->db->bind(':user_id', $user_id);
        $results = $this->db->rowCount();
        return $results;
    }

    public function getUserPostsAndRelations($user_id, $page = 1){
        $range = 6;
        $start = ($page - 1) * $range;

        $this->db->query('SELECT *,
                            posts.id as postId,
                            posts.title as postTitle,
                            posts.created_at as postCreatedAt,
                            posts.updated_at as postUpdatedAt,
                            posts.deleted_at as postDeletedAt,
                            users.id as userId,
                            users.created_at as userCreatedAt,
                            users.updated_at as userUpdatedAt,
                            users.deleted_at as userDeletedAt,
                            genres.id as genreId,
                            genres.title as genreTitle,
                            genres.created_at as genreCreatedAt,
                            genres.updated_at as genreUpdatedAt,
                            genres.deleted_at as genresDeletedAt,
                            (SELECT COUNT(id) FROM comments WHERE posts_id = posts.id) AS comments_count
                            FROM posts 
                            INNER JOIN users on posts.user_id = users.id
                            INNER JOIN genres on posts.genre_id = genres.id
                            WHERE user_id = :user_id AND posts.deleted_at IS NULL
                            ORDER BY posts.id DESC
                            LIMIT :start, :range ');

        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':start', $start);
        $this->db->bind(':range', $range);
        
        $results = $this->db->resultSet();
        if(empty($results)){
            Redirect::to('404');
        }
        return $results;
    }


    public function getAllPostsAndRelations(){

        $this->db->query('SELECT *,
                            posts.id as postId,
                            posts.created_at as postCreatedAt,
                            posts.updated_at as postUpdatedAt,
                            posts.deleted_at as postDeletedAt,
                            users.id as userId,
                            users.created_at as userCreatedAt,
                            users.updated_at as userUpdatedAt,
                            users.deleted_at as userDeletedAt,
                            (SELECT COUNT(id) FROM comments WHERE posts_id = posts.id) AS comments_count,
                            (SELECT title FROM genres WHERE id = posts.genre_id) AS genre
                            FROM posts 
                            INNER JOIN users
                            on posts.user_id = users.id WHERE posts.deleted_at IS NULL
                            ORDER BY posts.created_at DESC');


        $results = $this->db->resultSet();

        return $results;

    }



    public function getPostByIdOrTitle($id){

        if (is_int($id)) {
            $this->db->query('SELECT * FROM posts WHERE id = :id AND deleted_at IS NULL');
            $this->db->bind(':id', $id);
        }elseif(is_string($id)){
            $this->db->query('SELECT * FROM posts WHERE title = :title AND deleted_at IS NULL');
            $this->db->bind(':title', $id);
        }

        $row = $this->db->single();
        return $row;

    }
    
    public function getPostsByPageLimit($page = "1"){
        $range = 6;
        $start = ($page - 1) * $range;


        $this->db->query('SELECT *,
        posts.id as postId,
        posts.created_at as postCreatedAt,
        posts.updated_at as postUpdatedAt,
        posts.deleted_at as postDeletedAt,
        users.id as userId,
        users.created_at as userCreatedAt,
        users.updated_at as userUpdatedAt,
        users.deleted_at as userDeletedAt,
        (SELECT COUNT(id) FROM comments WHERE posts_id = posts.id) AS comments_count,
        (SELECT title FROM genres WHERE id = posts.genre_id) AS genre,
        (SELECT id FROM genres WHERE id = posts.genre_id) AS genreId
        FROM posts 
        INNER JOIN users 
        on posts.user_id = users.id WHERE posts.deleted_at IS NULL
        ORDER BY posts.id 
        DESC LIMIT :start, :range ');

        $this->db->bind(':start', $start);
        $this->db->bind(':range', $range);
       

        $results = $this->db->resultSet();
        if(empty($results)){
            // Redirect::to('404');
        }
        return $results;

    }


    public function getRecentPosts($range = 5){

        $this->db->query('SELECT * FROM posts WHERE deleted_at IS NULL ORDER BY id DESC LIMIT 0, :range');
        $this->db->bind(':range', $range);
       
        $results = $this->db->resultSet();
        return $results;
    }


    public function getAllPostsBygenre($genre, $page = 1){
        $range = 6;
        $start = ($page - 1) * $range;
        $genre = str_replace('-', ' ', $genre);

        $this->db->query('SELECT *,
        posts.id as postId,
        posts.title as postTitle,
        posts.created_at as postCreatedAt,
        posts.updated_at as postUpdatedAt,
        posts.deleted_at as postDeletedAt,
        users.id as userId,
        users.created_at as userCreatedAt,
        users.updated_at as userUpdatedAt,
        users.deleted_at as userDeletedAt,
        genres.id as genreId,
        genres.title as genreTitle,
        genres.created_at as genreCreatedAt,
        genres.updated_at as genreUpdatedAt,
        genres.deleted_at as genreDeletedAt,
        (SELECT COUNT(id) FROM comments WHERE posts_id = posts.id AND deleted_at IS NULL) AS comments_count
        FROM posts 
        INNER JOIN users 
        on posts.user_id = users.id
        INNER JOIN genres 
        on posts.genre_id = genres.id 
        WHERE posts.deleted_at IS NULL AND genres.deleted_at IS NULL AND genres.title = :genre_title
        ORDER BY posts.id 
        DESC LIMIT :start, :range ');

        $this->db->bind(':genre_title', $genre);
        $this->db->bind(':start', $start);
        $this->db->bind(':range', $range);
       

        $results = $this->db->resultSet();
    
        return $results;

    }

    public function getUserPosts($user_id, $page = 1){
        $range = 6;
        $start = ($page - 1) * $range;

        $this->db->query('SELECT *,
        posts.id as postId,
        posts.created_at as postCreatedAt,
        posts.updated_at as postUpdatedAt,
        posts.deleted_at as postDeletedAt,
        users.id as userId,
        users.created_at as userCreatedAt,
        users.updated_at as userUpdatedAt,
        users.deleted_at as userDeletedAt,
        (SELECT COUNT(id) FROM comments WHERE posts_id = posts.id) AS comments_count,
        (SELECT title FROM genres WHERE id = posts.genre_id) AS genre,
        (SELECT id FROM genres WHERE id = posts.genre_id) AS genreId
        FROM posts 
        INNER JOIN users 
        on posts.user_id = users.id WHERE posts.deleted_at IS NULL AND posts.user_id = :user_id 
        ORDER BY posts.id 
        DESC LIMIT :start, :range ');

        $this->db->bind(':start', $start);
        $this->db->bind(':range', $range);
        $this->db->bind(':user_id', $user_id);
       

        return $this->db->resultSet();
       
    }


    public function getUserAudiosPosts($user_id, $page = 1){
        $range = 6;
        $start = ($page - 1) * $range;


        $this->db->query('SELECT *,
        posts.id as postId,
        posts.created_at as postCreatedAt,
        posts.updated_at as postUpdatedAt,
        posts.deleted_at as postDeletedAt,
        users.id as userId,
        users.created_at as userCreatedAt,
        users.updated_at as userUpdatedAt,
        users.deleted_at as userDeletedAt,
        (SELECT COUNT(id) FROM comments WHERE posts_id = posts.id) AS comments_count,
        (SELECT title FROM genres WHERE id = posts.genre_id) AS genre,
        (SELECT id FROM genres WHERE id = posts.genre_id) AS genreId
        FROM posts 
        INNER JOIN users 
        on posts.user_id = users.id WHERE posts.deleted_at IS NULL AND posts.user_id = :user_id AND posts.mix_type = "audio/mpeg"
        ORDER BY posts.id 
        DESC LIMIT :start, :range ');

        $this->db->bind(':start', $start);
        $this->db->bind(':range', $range);
        $this->db->bind(':user_id', $user_id);
       

        return $this->db->resultSet();
    }

    public function getUserVideosPosts($user_id, $page = 1){
        $range = 6;
        $start = ($page - 1) * $range;


        $this->db->query('SELECT *,
        posts.id as postId,
        posts.created_at as postCreatedAt,
        posts.updated_at as postUpdatedAt,
        posts.deleted_at as postDeletedAt,
        users.id as userId,
        users.created_at as userCreatedAt,
        users.updated_at as userUpdatedAt,
        users.deleted_at as userDeletedAt,
        (SELECT COUNT(id) FROM comments WHERE posts_id = posts.id) AS comments_count,
        (SELECT title FROM genres WHERE id = posts.genre_id) AS genre,
        (SELECT id FROM genres WHERE id = posts.genre_id) AS genreId
        FROM posts 
        INNER JOIN users 
        on posts.user_id = users.id WHERE posts.deleted_at IS NULL AND posts.user_id = :user_id AND posts.mix_type = "video/mp4"
        ORDER BY posts.id 
        DESC LIMIT :start, :range ');

        $this->db->bind(':start', $start);
        $this->db->bind(':range', $range);
        $this->db->bind(':user_id', $user_id);
       

        return $this->db->resultSet();
    }
}
?>