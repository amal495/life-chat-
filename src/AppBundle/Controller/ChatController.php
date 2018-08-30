<?php
/**
 * Created by PhpStorm.
 * User: Trent
 * Date: 10/12/2017
 * Time: 9:55 PM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


class ChatController extends Controller
{

    /**
     * @Route("/",name="homepage")
     */
    public function homepageAction() {
        return $this->render('chat/login.html.twig');
    }





    /**
     * @Route("/chat/room" ,name="chat")
     */
    public function showAction() {

        $chatroom = "TEST_ROOM";
        $template = $this->container->get('templating');
        $html = $template->render('chat/chat.html.twig',
            ['chat'=> $chatroom]);
        $cache = $this->get('doctrine_cache.providers.my_cache');

        return new Response($html);
    }

    /**
     * @Route("admin/change/{id}/{role}", name="change")
     *
     * Changes user's role
     */
    public function adminPromoteAction(int $id, string $role)
    {
        $adminPanel = $this->get('chat.AdminPanel');
        $adminPanel->changeUsersRole($id, $role);

        return $this->redirectToRoute('admin');
    }


    /**
     * @Route("/admin",name="admin")
     */
    public function adminAction() {
        $em = $this->getDoctrine()->getManager();
        //$users = $em->getRepository('AppBundle:User')->findAllVerified();
        $users = $em->getRepository('AppBundle:User')->findAll();
        return $this->render('chat/admin.html.twig', [
            'users' => $users,
        ]);
    }



}