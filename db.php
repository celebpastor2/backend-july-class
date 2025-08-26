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
            $value = $values[$x];
            $holder = $placeholders[$x];
            $stmt->bindParam($holder, $value);
        }

        $stmt->execute();
        return true;

    }
}

$db = new DB();//no code is running
echo $db->insert("Books", array("title" => "Unlocking Android", "isbn" => "1933988673", "pageCount" => "416", "publishedDate" =>"2009-04-01T00:00:00.000-0700", "thumbnailUrl" => "https://s3.amazonaws.com/AKIAJC5RLADLUMVRPFDQ.book-thumb-images/ableson.jpg", "shortDescription" => "Unlocking Android: A Developer's Guide provides concise, hands-on instruction for the Android operating system and development tools. This book teaches important architectural concepts in a straightforward writing style and builds on this with practical and useful examples throughout.", "longDescription" => "Android is an open source mobile phone platform based on the Linux operating system and developed by the Open Handset Alliance, a consortium of over 30 hardware, software and telecom companies that focus on open standards for mobile devices. Led by search giant, Google, Android is designed to deliver a better and more open and cost effective mobile experience.    Unlocking Android: A Developer's Guide provides concise, hands-on instruction for the Android operating system and development tools. This book teaches important architectural concepts in a straightforward writing style and builds on this with practical and useful examples throughout. Based on his mobile development experience and his deep knowledge of the arcane Android technical documentation, the author conveys the know-how you need to develop practical applications that build upon or replace any of Androids features, however small.    Unlocking Android: A Developer's Guide prepares the reader to embrace the platform in easy-to-understand language and builds on this foundation with re-usable Java code examples. It is ideal for corporate and hobbyists alike who have an interest, or a mandate, to deliver software functionality for cell phones.    WHAT'S INSIDE:        * Android's place in the market      * Using the Eclipse environment for Android development      * The Intents - how and why they are used      * Application classes:            o Activity            o Service            o IntentReceiver       * User interface design      * Using the ContentProvider to manage data      * Persisting data with the SQLite database      * Networking examples      * Telephony applications      * Notification methods      * OpenGL, animation & multimedia      * Sample Applications " , "status" => "PUBLISH", "authors" => implode(",", ["W. Frank Ableson", "Charlie Collins", "Robi Sen"]), "categories" => implode(",",  ["Open Source", "Mobile"])));