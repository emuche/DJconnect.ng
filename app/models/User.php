<?php
class User{
    private $db;

    public function __construct(){
        $this->db = new Database;

    }

    public function register($data){
        $this->db->query('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }

    }


    public function login($email, $password){

        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $this->db->query('SELECT * FROM users WHERE email = :email AND deleted_at IS NULL');
            $this->db->bind(':email', $email);
        }else{
            $this->db->query('SELECT * FROM users WHERE username = :username AND deleted_at IS NULL');
            $this->db->bind(':username', $email);
        }
        $row = $this->db->single();
        $hashed_password =  $row->password;
        if (password_verify($password, $hashed_password)) {
            return $row;
        }else{
            return false;
        }
    }

    public function findUserByEmail($email){
        $this->db->query('SELECT * FROM users WHERE email = :email AND deleted_at IS NULL');
        $this->db->bind(':email', $email);

        $row = $this->db->single();
        return $row;
    }

    public function findUserByUsername($username){
        $this->db->query('SELECT * FROM users WHERE username = :username AND deleted_at IS NULL');
        $this->db->bind(':username', $username);
        $row = $this->db->single();
        return $row;
    }


    public function findUserById($id){
        $this->db->query('SELECT * FROM users WHERE id = :id');
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        return $row;
    }

    public function getUserAndProfileByUserId($id){
        
        $this->db->query('SELECT *,
                            users.id as userId,
                            users.created_at as userCreatedAt,
                            users.updated_at as userUpdatedAt,
                            users.deleted_at as userDeletedAt,
                            profiles.id as profileId,
                            profiles.created_at as profileCreatedAt,
                            profiles.updated_at as profileUpdatedAt,
                            profiles.deleted_at as profileDeletedAt
                            FROM users 
                            INNER JOIN profiles
                            on users.id = profiles.user_id WHERE deleted_at IS NULL
                            WHERE users.id = :user_id');

        $this->db->bind(':user_id', $id);
        $row = $this->db->single();
        return $row;

    }

    public function getUserProfileByUsername($username){
        $this->db->query('SELECT *,
        users.id as userId,
        users.created_at as userCreatedAt,
        users.updated_at as userUpdatedAt,
        users.deleted_at as userDeletedAt,
        profiles.id as profileId,
        profiles.created_at as profileCreatedAt,
        profiles.updated_at as profileUpdatedAt,
        profiles.deleted_at as profileDeletedAt
        FROM users 
        INNER JOIN profiles on users.id = profiles.user_id
        WHERE users.username = :username AND users.deleted_at IS NULL AND profiles.deleted_at IS NULL');

        $this->db->bind(':username', $username);

        $results = $this->db->resultSet();
        return $results;

    }
   
}
?>