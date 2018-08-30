<?php
/**
 * Created by PhpStorm.
 * User: Trent
 * Date: 11/14/2017
 * Time: 10:12 AM
 */

namespace AppBundle\EventListener;


use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class RedirectAfterRegistrationSubscriber implements EventSubscriberInterface
{

    use TargetPathTrait;

    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function onRegistrationSuccess(FormEvent $event) {

        $url = $this->getTargetPath($event->getRequest()->getSession(),'main');

        if (!$url) {
            $url = $this->router->generate('chat');
        }

        $url = $this->router->generate('chat');
        $response = new RedirectResponse($url);
        $event->setResponse($response);

    }

    public static function getSubscribedEvents()
    {
        return [
            FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSuccess'
        ];
    }
}