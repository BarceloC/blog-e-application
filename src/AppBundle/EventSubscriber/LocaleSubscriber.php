<?php

namespace AppBundle\EventSubscriber;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Negotiation\LanguageNegotiator;

class LocaleSubscriber implements EventSubscriberInterface
{
    private $defaultLocale;
    protected $supportedLanguages;

    public function __construct($defaultLocale = 'en')
    {
        $this->defaultLocale = $defaultLocale;
        $this->supportedLanguages = array("fr", "en");
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if (!$request->hasPreviousSession()) {
            return;
        }

        if($event->getRequest()->headers->get('Accept-Language') !== null)
        {
            $negotiator = new LanguageNegotiator();
            $best = $negotiator->getBest($event->getRequest()->headers->get('Accept-Language'), $this->supportedLanguages);
            if (null !== $best) 
            {
                $language = $best->getType();
                $request->setLocale($request->getSession()->get('_locale', $language));
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return array(
            // must be registered before (i.e. with a higher priority than) the default Locale listener
            KernelEvents::REQUEST => array(array('onKernelRequest', 20)),
        );
    }
}