<?php


namespace App\EventSubscribers;


use App\Kernel;
use Aws\S3\S3Client;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Contracts\Service\Attribute\Required;

class S3Subscriber implements EventSubscriberInterface
{
    #[Required]
    public S3Client $s3Client;
    public static function getSubscribedEvents():array
    {
        return [
            KernelEvents::class => 'onKernelEvent',
        ];
    }


    public function onKernelEvent(KernelEvents|ConsoleCommandEvent $event)
    {
        $this->s3Client->registerStreamWrapper();
    }
}