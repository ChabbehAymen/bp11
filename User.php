<?php
class User{
    private $name;
    private $last_name;
    private $email;
    private $birth_day;
    private $user_name;
    private $password;

    // fields setters
    public function setName(string $name){
        $this->name = $name;
    }

    public function setLastName(string $last_name){
        $this->last_name = $last_name;
    }
    public function setEmail(string $email){
        $this->email = $email;
    }
    public function setBirthDay(string $birth_day){
        $this->birth_day = $birth_day;
    }
    public function setUserName(string $user_name){
        $this->user_name = $user_name;
    }
    public function setPassword(string $password){
        $this->password = $password;
    }


    // fields getters
    public function getName(){
        return $this->name;
    }
    public function getLastName(){
        return $this->last_name;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getBirthDay(){
        return $this->birth_day;
    }
    public function getUserName(){
        return $this->user_name;
    }
    public function getPassword(){
        return $this->password;
    }

    public function __toArray($user_id){
        return [
            "userID"=> $user_id,
            "name"=> (string)$this->getName(),
            "lastName"=>(string)$this->getLastName(),
            "email"=> (string)$this->getEmail(),
            "birthDay"=> (string)$this->getBirthDay(),
            "userName"=> (string)$this->getUserName(),
            "password"=> (string)$this->getPassword(),
            "lastSastion"=>""
        ];
    }

}