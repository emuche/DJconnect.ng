<?php
class Audio{
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function getAudiosByPageLimit($page = 1){
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
        on posts.user_id = users.id 
        WHERE posts.mix_type = "audio/mpeg" AND  posts.deleted_at IS NULL
        ORDER BY posts.id 
        DESC LIMIT :start, :range ');

        $this->db->bind(':start', $start);
        $this->db->bind(':range', $range);
       

        $results = $this->db->resultSet();
        return $results;
    }
}
?>