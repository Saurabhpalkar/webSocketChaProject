<?php
$error = '';
$success_msg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    // if (isset($_SESSION['user_data'])) {
    //     header("location:chatRoom.php");
    //     exit(); // Ensure script execution stops after redirection
    // }

    require_once('database/chat_users.php');
    $user_obj = new chat_user;
    if (isset($_POST['register'])) {
        $user_obj->setUserName($_POST['name']);
        $user_obj->setUserEmail($_POST['email']);
        $user_obj->setUserPassword($_POST['password']);
        $user_obj->setUserStatus('ACTIVE');
        $user_obj->setUsercreatedOn(date("Y-m-d H:i:s"));
        $user_obj->setUserVerificationCode(md5(uniqid())); //used to verify user email addr
        $user_exist =  $user_obj->check_user_exist();

        if (is_array($user_exist) && count($user_exist) > 0) {
            $error = "This email is already registered";
        } else {
            if ($user_obj->insertUserData()) {
                $success_msg = "Registration success";
            } else {
                $error = "Something went wrong";
            }
        }
    } else if(isset($_POST['login_btn'])){
        $user_obj->setUserEmail($_POST['email']);
        $user_data = $user_obj->check_user_exist();
        if(is_array($user_data) && count($user_data)>0){
            if($user_data['user_password'] == $_POST['password']){
                $user_obj->setUserStatus("ENABLE");
                $user_obj->setUserId($user_data['id']);
                if($user_obj->updateLoginUserStatus()){
                    $_SESSION['user_data'][$user_data['id']] = [
                        'id'=> $user_data['id'],
                        'name'=>$user_data['user_name']
                    ];
                    $success_msg = "login success";
                    // header('location: chatRoom.php');
                    // exit();

                } 
            }else{
                $error = "Wrong password enter";
            }
        }else{
            $error = 'Email Address not Exist';
        }
    }

    // Prepare the response
    $response = array();
    $response['error'] = $error;
    $response['success_msg'] = $success_msg;
    echo json_encode($response);
} else {
    // Handle invalid requests
    echo "Invalid Request";
}
