<?php
class chat_user
{
    private $user_id;
    private $user_name;
    private $user_email;
    private $user_password;
    // private $user_profile;
    private $user_status;
    private $user_created_on;
    private $user_verification_code;
    // private $user_login_status;
    private $connect;

    public function __construct()
    {
        require_once("db_connection.php");
        $db_conn = new database;
        $this->connect = $db_conn->connect();
        // if ($this->connect) {
        //     echo "connection success";
        // } else {
        //     echo "connection faild";
        // }
    }
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }
    public function getUserId()
    {
        return $this->user_id;
    }
    public function setUserName($user_name)
    {
        $this->user_name = $user_name;
    }
    public function getUserName()
    {
        return $this->user_name;
    }
    public function setUserEmail($user_email)
    {
        $this->user_email = $user_email;
    }
    public function getUserEmail()
    {
        return $this->user_email;
    }
    public function setUserPassword($user_password)
    {
        $this->user_password = $user_password;
    }
    public function getUserPassword()
    {
        return $this->user_password;
    }
    // public function setUserProfile($user_profile)
    // {
    //     $this->user_profile = $user_profile;
    // }
    // public function getUserProfile()
    // {
    //     return $this->user_profile;
    // }
    public function setUserStatus($user_status)
    {
        $this->user_status = $user_status;
    }
    public function getUserStatus()
    {
        return $this->user_status;
    }
    public function setUsercreatedOn($user_created_on)
    {
        $this->user_created_on = $user_created_on;
    }
    public function getUserCreatedOn()
    {
        return $this->user_created_on;
    }
    public function setUserVerificationCode($user_verification_code)
    {
        $this->user_verification_code = $user_verification_code;
    }
    public function getUserVerificationCode()
    {
        return $this->user_verification_code;
    }
    // public function setUserLoginStatus($user_login_status)
    // {
    //     $this->user_login_status = $user_login_status;
    // }
    // public function getUserLoginStatus()
    // {
    //     return $this->user_login_status;
    // }
    // // public function makeAvtar(){

    // }
    public function check_user_exist(){
        $query = "SELECT * FROM chat_user_table WHERE user_email = :user_email";
        $statement = $this->connect->prepare($query);
        $statement->bindParam(":user_email", $this->user_email);
        if($statement->execute()){
            $user_data = $statement->fetch(PDO::FETCH_ASSOC);                   
        }
        return $user_data;
    }
    public function insertUserData(){
        $query = "INSERT INTO chat_user_table(user_name, user_email, user_password, user_status, user_created_on, user_verification_code)
                  VALUES(:user_name, :user_email, :user_password, :user_status, :user_created_on, :user_verification_code)";
        $statement = $this->connect->prepare($query);
        $statement->bindParam(":user_name", $this->user_name);
        $statement->bindParam(":user_email", $this->user_email);
        $statement->bindParam(":user_password", $this->user_password);
        // $statement->bindParam(":user_profile", $this->user_profile);
        $statement->bindParam(":user_status", $this->user_status);
        $statement->bindParam(":user_created_on", $this->user_created_on);
        $statement->bindParam(":user_verification_code", $this->user_verification_code);
        if($statement->execute()){
            return true;
        }else{
            return false; 
        }
    }
    function updateLoginUserStatus(){
        $query = "UPDATE chat_user_table SET user_status = :user_status
        WHERE id = :user_id";
        $statement = $this->connect->prepare($query);
        $statement->bindParam(":user_status", $this->user_status);
        $statement->bindParam(":user_id", $this->user_id);
        if($statement->execute()){
            return true;
        }else{
            return false;
        }

    }
    function get_data_by_user_id(){
     $query = "SELECT * FROM chat_user_table WHERE id = :user_id";
        $statement = $this->connect->prepare($query);
        $statement->bindParam(":user_id", $this->user_id);
        if($statement->execute()){
            $user_data = $statement->fetch(PDO::FETCH_ASSOC);                   
        }
        return $user_data;
    }
}
// $a = new chat_user;
