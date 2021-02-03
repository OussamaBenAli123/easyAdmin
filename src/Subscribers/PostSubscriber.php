<?php


namespace App\Subscribers;


use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Validator\Constraints\Date;

class PostSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['setDefaultDateAndState']
            ];
    }

    public function setDefaultDateAndState(BeforeEntityPersistedEvent $event)
    {
        if($event->getEntityInstance() instanceof Post)
        {
            /**
             * @var Post $post
             */
            $post = $event->getEntityInstance();
            $post->setDateCreated(new \DateTime());
            $post->setStatus('Pending');
        }
    }
}