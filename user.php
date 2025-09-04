<?php

require "db.php";

class User {
    public $fullname;
    public $email;
    public $password = false;
    private $db;
    public function __construct(int $id, string $email = "", string $fullname = "", string $password = ""){
        $this->db = new DB();
        if(!$id && $fullname && $email && $password){
            
            $this->db->insert("Users", [
                "email" => $email,
                "fullname"  => $fullname,
                "password"  => password_hash($password, PASSWORD_DEFAULT)
            ]);
        } else if($id || $email ){
            $where = [];
            if($id){
                $where['id'] = $id;
            }

            if( $email ){
                $where['email'] = $email;
            }
           $user = $this->db->get("Users", $where);

           if(! $user ) return;
           $this->email = $user['email'];
           $this->fullname = $user['fullname'];
           $this->password = $user['password'];
           $this->ID       = $user['id'];
        }
        
    }

    public function login(string $password){
        $islogin = false;
        if( $this->password ){
            $islogin = password_verify($password, $this->password );
        }
        return $islogin;
    }
}