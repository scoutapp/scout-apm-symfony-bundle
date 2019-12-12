<?php

declare(strict_types=1);

namespace Scoutapm\ScoutApmBundle\EventListener;

use Scoutapm\Events\Span\Span;
use Scoutapm\ScoutApmAgent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
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

    public function onKernelController(ControllerEvent $controllerEvent)
    {
        $this->agent->startSpan(Span::INSTRUMENT_CONTROLLER . '/eh'); // @todo determine controller name
    }

    public function onKernelResponse(ResponseEvent $responseEvent)
    {
        $this->agent->stopSpan();
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
            KernelEvents::CONTROLLER => ['onKernelController', -100],
            KernelEvents::RESPONSE => ['onKernelResponse', 0],
            KernelEvents::TERMINATE => ['onKernelTerminate', 0],
        ];
    }
}
