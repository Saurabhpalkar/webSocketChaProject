<?php
session_start();
// var_dump($_SESSION['user_data'][1]['name']);
if (!isset($_SESSION['user_data'])) {
    header("location:login.php");
}
require("database/chat_room_msgs.php");
$chat_obj = new user_chat_messages;
$chat_messages = $chat_obj->fetchAllChat();
// echo "<pre>";
// var_dump($chat_messages);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile Sidebar</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        /* Adjust styles as needed */
        .user-profile {
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
            padding: 20px;
            height: 100vh;
            /* Adjust the height as needed */
        }
        #message_area{
            min-height: 25rem;
            background-color: #3e3939;
        }
        /* .date {
            position: absolute;
            bottom: 0;
            right: 0;
        }*/
        small{
            float: inline-end;
            padding-top: 20px;
        } 
    </style>
</head>

<body>
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-md-3 user-profile">
                <h4>User Profile</h4>
                <?php
                    foreach($_SESSION['user_data'] as $key => $value ){
                        $login_user_id = $value['id'];
                ?>
                <input type="hidden" name="login_user_id" id="login_user_id" value="<?php echo $login_user_id?>">
                <p>Name: <?php echo $value['name'] ?></p>
                <a href="logout.php" class="btn btn-danger">Logout</a>
                <!-- <button class="btn btn-danger btn-block" onclick="logout()">Logout</button> -->
            </div>
            <?php }?>
            <!-- Main Content Area -->
            <div class="col-md-9 container" style="padding: 2rem 5rem 3rem 5rem;">
                <div class="card">
                    <div class="class-header text-white text-center" style="background-color: #0e0e0e;"><h4>Chat Room</h4></div>
                    <div class="card-body" id="message_area" >
                       <?php
                        foreach($chat_messages as $value){ 
                            if(isset($_SESSION['user_data'][$value['user_id']])){
                                $row_class = 'float-end';
                                $bg_class = 'alert-light';
                                $float_class = 'float-right';
                                $from = "Me";
                                // $align_class = 'text-right';
                            } else {
                                $from = $value['user_name'];
                                $row_class = ' float-end';
                                $bg_class = 'alert-success';
                                $float_class = 'float-left';

                            }
                            echo'<div col-sm-12><div class="' .$float_class.' col-sm-7"><div class="col-sm-12 shadow-sm alert ' .$bg_class .  ' ' .$float_class.'" style="width:fit-content; padding: inherit;"> <div class="' . $row_class . '">
                             <b>' . $from . ' </b> <br> ' . $value['messages'] . '<small class="date"><i>' . $value['created_on'] .
                            '</i></small></div></div></div></div>';
                     } ?>
                        
                    </div>
                </div>
                <form action="POST" id="chatRoomForm">
                    <div class="input-group mb-3">    
                        <textarea class="form-control" name="chat_msg" id="chat_msg" placeholder="Type your msg" maxlength="10000"></textarea>
                        <div class="input-group-append">
                            <button type="submit" name="send" value="send" id="send" class="btn btn-primary"><i class="fa fa-paper-plane"></i></button>
                        </div>
                    </div>    
                </form>
                <!-- Main content goes here -->
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Logout Functionality -->
    <script>
        $(document).ready(function() {

            var conn = new WebSocket('ws://localhost:8080');
            conn.onopen = function(e) {
                console.log("Connection established!");
            };

            conn.onmessage = function(e) {
               
                var data = JSON.parse(e.data);
                var row_class = '';
                    var bg_class = '';
                    var align_class = '';
                    if (data.from == 'Me') {
                        row_class = 'float-end';
                        bg_class = 'alert-light';
                        float_class = 'float-right';
                        // align_class = 'text-right';
                    } else {
                        row_class = ' float-end';
                        bg_class = 'alert-success';
                        float_class = 'float-left';

                        // align_class = 'text-left';
                    }
                    // var html_data = ' <div class=" bg-success col-sm-7  justify-content-end"> <b>' + data.from + '-</b><p>'+ data.msg +'<small>' + data.dt +'</small></p></div>';
                    var html_data = '<div col-sm-12><div class="'+float_class+' col-sm-7"><div class="col-sm-12 shadow-sm alert ' +
                        bg_class + ' ' + align_class + ' '+float_class+'" style="width:fit-content; padding: inherit;"> <div class="' + row_class + '"> <b>' + data.from + ' </b> <br> ' + data.msg + '<small class="date"><i>' + data.dt +
                        '</i></small></div></div></div></div>';
                $('#message_area').append(html_data);
                $('#chat_msg').val('')
            };
            $('#message_area').scrollTop($('#message_area')[0].scrollHeight);
            $('#chatRoomForm').on('submit', function(event){
                event.preventDefault()
                var user_id = $('#login_user_id').val() ;
                var msg= $('#chat_msg').val().trim();

                // send data to WebSocket
                var data = {
                    user_id : user_id,
                    msg : msg
                }
                conn.send(JSON.stringify(data));
            $('#message_area').scrollTop($('#message_area')[0].scrollHeight);

                
            })
            // $('#chat_msg').on('input', function() {
            //     $(this).css('width', 'auto');
            //     $(this).css('width', this.scrollWidth + 'px');
            // });
        });
        // function logout() {
        //     // Perform logout actions here, such as clearing session data, etc.
        //     alert('Logout successful!');
        //     // Redirect to logout page or perform other actions as needed
        //     window.location.href = 'logout.php';
        // }
    </script>
</body>

</html>