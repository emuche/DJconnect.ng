<?php
class Profile{
    private $db;

    public function __construct(){
        $this->db = new Database;

    }

    public function getProfileByUserId($user_id){
        $this->db->query('SELECT * FROM profiles WHERE user_id = :user_id AND deleted_at IS NULL');
        $this->db->bind(':user_id', $user_id);
        $row = $this->db->single();
        return $row;
    }

    public function getAllDjs($page = 1){

        $range = 6;
        $start = ($page - 1) * $range;


        $this->db->query('SELECT *,
        profiles.id as profileId,
        profiles.created_at as profileCreatedAt,
        profiles.updated_at as profileUpdatedAt,
        profiles.deleted_at as profileDeletedAt,
        users.id as userId,
        users.created_at as userCreatedAt,
        users.updated_at as userUpdatedAt,
        users.deleted_at as userDeletedAt
        FROM profiles 
        INNER JOIN users
        ON profiles.user_id = users.id 
        WHERE users.privilege = "user" AND profiles.deleted_at IS NULL 
        AND users.deleted_at IS NULL AND active = 1 AND users.username IS NOT NULL
        ORDER BY profiles.id 
        DESC LIMIT :start, :range ');

        $this->db->bind(':start', $start);
        $this->db->bind(':range', $range);

        return $this->db->resultSet();
    }
}
?>