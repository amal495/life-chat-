<?php
/**
 * Created by PhpStorm.
 * User: Trent
 * Date: 11/15/2017
 * Time: 11:44 AM
 */

namespace AppBundle\Command;

use AppBundle\WebSocket\ChatSocket;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

class ServerCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('chat:socket')
            ->setDescription('Start the chat socket');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $chat = $this->getContainer()->get('chat');
        $server = IoServer::factory(
            new HttpServer(
                new WsServer($chat)
            ),
            8080
        );
        $output->write("Socket running on port:8080...\n");
        $server->run();
    }

}