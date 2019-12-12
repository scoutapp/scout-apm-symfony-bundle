<?php

declare(strict_types=1);

namespace Scoutapm\ScoutApmBundle\EventListener;

use Scoutapm\ScoutApmAgent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\TerminateEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/** @noinspection PhpUnused */
/** @noinspection ContractViolationInspection */
final class InstrumentationListener implements EventSubscriberInterface
{
    /** @var ScoutApmAgent */
    private $agent;

    public function __construct(ScoutApmAgent $agent)
    {
        $this->agent = $agent;
    }

    public function onKernelRequest(RequestEvent $requestEvent)
    {
        $this->agent->connect();
    }

    /** @throws \Exception */
    public function onKernelTerminate(TerminateEvent $terminateEvent)
    {
        $this->agent->send();
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', -100],
            KernelEvents::TERMINATE => ['onKernelTerminate', -1024],
        ];
    }
}
