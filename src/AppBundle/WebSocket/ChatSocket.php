<?php
/**
 * Created by PhpStorm.
 * User: Trent
 * Date: 11/15/2017
 * Time: 10:15 AM
 */

namespace AppBundle\WebSocket;


use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\MessageComponentInterface;
use AppBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;


class ChatSocket implements MessageComponentInterface {


    protected $clients;
    private $em;
    /** @var  ContainerInterface $container */
    private $container;
    private $subscriptions;
    private $users;
    private $online;



    public function __construct(EntityManager $em,ContainerInterface $container)
    {
        $this->clients = new \SplObjectStorage;
        $this->em = $em;
        $this->container = $container;
        $this->subscriptions = [];
        $this->users = [];
        $this->online = [];
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);
        echo "connection ({$conn->resourceId}) has logged in!\n";
        $this->users[$conn->resourceId] = $conn;


    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;

       echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        //converts stdClass arr to assoc arr
         $data = json_decode($msg,true);

         print_r($data);
        switch ($data['command']) {
            case "subscribe":
                $this->subscriptions[$from->resourceId] = $data->channel;
                break;
            case "message":
                if (isset($this->subscriptions[$from->resourceId])) {
                    $target = $this->subscriptions[$from->resourceId];
                    foreach ($this->subscriptions as $id=>$channel) {
                        if ($channel == $target && $id != $from->resourceId) {
                            $this->users[$id]->send($data->message);
                        }
                    }
                }
                foreach ($this->clients as $client) {
                    // The sender is not the receiver, send to each client connected
                    // if ($from !== $client) {
                        echo "message test";
                        $client->send($msg);
                    //}
                }
                break;
            case "connect":
                    $this->online[$from->resourceId] = $data['user'];
                foreach ($this->clients as $client) {
                    print_r($this->online);
                    $client->send(json_encode($this->online));
                    //convert 'user is online' messages to 'message' json
                    $client->send(json_encode(array("command"=>"message",
                        "message"=>$this->online[$from->resourceId]. " has joined the room!")));
                }
                break;
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);
        unset($this->users[$conn->resourceId]);
        unset($this->subscriptions[$conn->resourceId]);

        // sends a message to every client that user has disconnected
        foreach ($this->clients as $client) {
            $client->send(json_encode(array("command"=>"message",
                "message"=>$this->online[$conn->resourceId]. " has left the room")));
        }
        unset($this->online[$conn->resourceId]);
        foreach ($this->clients as $client) {
            print_r($this->online);
            $client->send(json_encode($this->online));
        }

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "\n***An error has occurred: {$e->getMessage()} line ".$e->getLine()."***\n";
        $conn->close();
    }


}