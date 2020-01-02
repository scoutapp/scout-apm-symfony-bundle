<?php

declare(strict_types=1);

namespace Scoutapm\ScoutApmBundle\EventListener;

use Exception;
use Scoutapm\Events\Span\Span;
use Scoutapm\ScoutApmAgent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/** @noinspection ContractViolationInspection */
final class InstrumentationListener implements EventSubscriberInterface
{
    /** @var ScoutApmAgent */
    private $agent;

    public function __construct(ScoutApmAgent $agent)
    {
        $this->agent = $agent;
    }

    /** @noinspection PhpUnused */
    public function onKernelRequest() : void
    {
        $this->agent->connect();
    }

    /**
     * @throws Exception
     *
     * @noinspection PhpUnused
     */
    public function onKernelController(ControllerEvent $controllerEvent) : void
    {
        /** @noinspection UnusedFunctionResultInspection */
        $this->agent->startSpan(Span::INSTRUMENT_CONTROLLER . '/eh'); // @todo determine controller name
    }

    /** @noinspection PhpUnused */
    public function onKernelResponse() : void
    {
        $this->agent->stopSpan();
    }

    /**
     * @throws Exception
     *
     * @noinspection PhpUnused
     */
    public function onKernelTerminate() : void
    {
        $this->agent->send();
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents() : array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', -100],
            KernelEvents::CONTROLLER => ['onKernelController', -100],
            KernelEvents::RESPONSE => ['onKernelResponse', 0],
            KernelEvents::TERMINATE => ['onKernelTerminate', 0], // @todo maybe finish response is more appropriate - check this out?
        ];
    }
}
