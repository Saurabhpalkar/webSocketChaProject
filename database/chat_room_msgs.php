<?php
class user_chat_messages{
    private $user_id;
    private $msgs;
    private $created_on;
    protected $connect;
    function __construct(){
        require_once("db_connection.php");
        $connection = new database;
        $this->connect = $connection->connect();
    }
    function setUserId($user_id){
        $this->user_id = $user_id;
    }
    function getUserId(){
        return $this->user_id;
    } 
    function setmessages($msgs){
        $this->msgs = $msgs;
    }
    function getmessages(){
        return $this->user_id;
    } 
    function setCreatedOn($created_on){
        $this->created_on = $created_on;
    }
    function insert_chat_msgs(){
        $query = "INSERT into chat_room_msgs (user_id, messages, created_on)
                    VALUES(:user_id,:messages,:created_on)";
        $statement = $this->connect->prepare($query);
          $statement->bindParam(":user_id", $this->user_id);
          $statement->bindParam(":messages", $this->msgs);
          $statement->bindParam(":created_on", $this->created_on);
          if($statement->execute()){
            echo "inserted";
          }else{
            echo "insertion";
          }
    }
    
}
?>