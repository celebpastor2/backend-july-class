<?php
class Books {
    //properties
    //methods
    //access modifiers
    //properties are data that your class will use
    //methods are how your class uses those data
    public $name = "Hello World";
    protected $shelf = "Main";
    private $db     = "Database";

    public function __construct($value){
        $this->name = $value;
    }

    public function changeName($to){
        $this->name = $to;
    }

    public function __destruct(){
        echo "<br> Bye";
    }
}

class Pages extends Books {
    public $shelf;
    public function __construct(){
        $this->shelf = "Pages Shelf";
        echo $this->db;  
    }
}

final class Store extends Pages {

}

$variable = new Books("My Name is Phillip");#runs when an object is initialized
#$variable->changeName("My Name is Phillip");
$var       = new Pages();
echo $var->shelf;