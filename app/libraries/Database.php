<?php

class Database{

    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $dbh;
    private $stmt;
    private $error;

    public function __construct(){
        $dsn = 'mysql:host='.$this->host.';dbname='.$this->dbname;

        $options = array(
            PDO::ATTR_PERSISTENT =>  true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }


    public function query($sql){
        $this->stmt = $this->dbh->prepare($sql);
    }

    public function bind($param, $value, $type = null){
        if(is_null($type)){
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_BOOL($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }

        }

        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute(){
        return $this->stmt->execute();
    }

    public function resultSet(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function single(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    public function rowCount(){
        $this->execute();
        return $this->stmt->rowCount();
    }

    public function read($table, $id){
		$this->query('SELECT * FROM :table where id = :id');
        $this->bind(':table', $table);
        $this->bind(':id', $id);
        return $this->resultSet();

	}

	public function delete($table, $id){

		$this->query('DELETE FROM :table WHERE id = :id');
        $this->bind(':table', $table);
        $this->bind(':id', $id);

        if($this->execute()){
            return true;
        }else{
            return false;
        }

	}

	public function first(){
		return $this->resultSet()[0];
	}

	public function last(){
		$count = $this->rowCount();
		$x = $count - 1;
		return $this->resultSet()[$x];
	}

	public function create($table, $data = array()){

        $fields = '';
        $values = '';
        $count = count($data);
        $x = 0;

        foreach($data as $key => $value){
            if($x == $count - 1){
                $fields .= $key;
                $values .= ':'.$key;
            }else{
                $fields .= $key.', ';
                $values .= ':'.$key.', ';
            }
           $x++;
        }

        $this->query('INSERT INTO :table ('.$fields.') VALUES ('.$values.')');
        $this->bind(':table', $table);
        
        foreach($data as $key => $value){
            $this->bind(':'.$key, $value);
        }

        if($this->execute()){
            return true;
        }else{
            return false;
        }

	}

	
    public function update($table, $id, $data = array()){
        
        $fields = '';
        $count = count($data);
        $x = 0;

        foreach($data as $key => $value){
            if($x == $count - 1){
                $fields .= $key.' = :'.$key;
            }else{
                $fields .= $key.' = :'.$key.', ';
            }
           $x++;
        }

        $this->query('UPDATE :table SET '.$fields.' WHERE id = :id');
        $this->bind(':table', $table);
        $this->bind(':id', $id);
        
        foreach($data as $key => $value){
            $this->bind(':'.$key, $value);
        }

        if($this->execute()){
            return true;
        }else{
            return false;
        }
	}

    public function run(){
        return $this->create('genre', ['title'=>'soft rock', 'name'=> 'uche']);
    }

	
}

