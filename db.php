<?php

class DB {
   
    //CRUD
    //Relationship JOIN - INNER JOIN OUTER JOIN 
    private $hostname = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname  = "appclick";
    private $pdo  = false;

    public function __construct(){
        $dsn = "mysql:host={$this->hostname};dbname={$this->dbname}";
        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            //echo "Connection Succeeded";
        } catch(PDOException $e){
            $this->pdo = false;
            echo "Connection Error " . $e->getMessage();
        }
        
    }

    public function method2(){
        return $this->anotherProp;
    }

    public function method1(){
        return $this->anotherProp;
    }

    public function insert(string $tableName, array $args){
        if( ! $this->pdo ){
            return false;
        }
        $columns = array_keys($args);       

        $sql = "CREATE TABLE IF NOT EXISTS $tableName (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        ";
        $placeholders = [];
        foreach($columns as $column ){
            $sql .= "$column TEXT, ";
            array_push($placeholders, ":$column");
        }
        $sql .= "time TIMESTAMP DEFAULT CURRENT_TIMESTAMP )";
        //create table if the table does not exist
        $this->pdo->exec($sql);


        $columns = implode( " , ", $columns );
        
        $values = array_values($args);
        $placeholder = implode(" , ", $placeholders);
        //INSERT INTO Books (author, isbn, price, pages) VALUES(:author, :isbn, :price, :pages)
        $stmt = $this->pdo->prepare("INSERT INTO $tableName ($columns) VALUES($placeholder)");

        for( $x = 0; $x < count($placeholders); $x++){

            if(is_array($values[$x])){
                $values[$x] = implode(",", $values[$x]);
            }
            $stmt->bindParam($placeholders[$x],$values[$x]);//pointers RAM
        }

        $stmt->execute();
        return true;

    }

    public function getAll($tableName, $limit = 20, $offset = 0, $search = []){
        if( ! $this->pdo ){
            return false;
        }
        $sql = "SELECT * FROM $tableName ";
        $search_holders = [];

        if( count($search) > 0 ){
            $sql .= "WHERE ";
            foreach($search as $column => $value){
                $sql .= "$column LIKE %:$column%";
                array_push($search_holder, ":$column");
            }
        }       

        $sql .= "LIMIT :limited OFFSET :offseted";



        //LIKE :likes LIMIT :limited OFFSET :offseted 

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":limited", $limit, PDO::PARAM_INT);
        $stmt->bindValue(":offseted", $limit, PDO::PARAM_INT);
       if( count($search) > 0){
            foreach($search_holder as $holder){
                $name = str_replace(":", "", $holder);
                $value = $search[$name];
                $stmt->bindValue("$holder", "$value");
            }
       }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function get( $tableName, array $where = [], array $columns = [], $single = true, $compare = "="){
        try {
            if( ! $this->pdo ){
                return false;
            }

            if( count($columns) == 0 ){
                $columns = "*";
            } else {
                $columns = implode(",", $columns);
            }
            $values = [];
            if( count($where) == 0){
                $where = "1=1";
            } else {
                $str = "";          
                foreach($where as $key => $value){
                    $str .= "$key $compare :$key";
                    $values[":$key"]   = $value;
                }
                $where = $str;

            }

            $stmt = $this->pdo->prepare("SELECT $columns FROM $tableName WHERE $where");

            $stmt->execute($values);

            if($single )
                return $stmt->fetch(); 
            
            return $stmt->fetchAll();
        } catch(PDOException $e){
            return false;
        }
        
    }

    public function __destruct(){
        $this->pdo = null;
    }
}

