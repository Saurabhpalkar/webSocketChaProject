<?php
namespace MyApp;

use chat_msgs;
use chat_user;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use user_chat_messages;
use user_chat_msgs;

require dirname(__DIR__) . "/database/chat_users.php";
require dirname(__DIR__) . "/database/chat_room_msgs.php";


class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');
        $data = json_decode($msg, true);
        // require("database/chat_room_msgs.php");
        $chat_obj = new user_chat_messages;
        $chat_obj->setUserId($data['user_id']);
        $chat_obj->setmessages($data['msg']); 
        $chat_obj->setCreatedOn(date("Y-m-d h:i:s")); 
        $chat_obj->insert_chat_msgs();
        $user_obj = new chat_user;
        $user_obj->setUserId($data['user_id']);
        $user_data = $user_obj->get_data_by_user_id();
        // if(!$user_data){
        //     echo "not user name founf";
        //     return;
        // }
        $user_name = $user_data['user_name'];
        // var_dump($user_name);

        $data['dt'] = date("h:i");
        foreach ($this->clients as $client) {
            // if ($from !== $client) {
            //     // The sender is not the receiver, send to each client connected
            //     $client->send($msg);
            // }
            if($from == $client){
                $data['from'] = "Me";
            }else{
                $data['from'] = $user_name;
            }
            $client->send(json_encode($data));
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}