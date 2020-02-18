<?php

declare(strict_types=1);

namespace Scoutapm\ScoutApmBundle\EventListener;

use Closure;
use Exception;
use ReflectionClass;
use ReflectionException;
use Scoutapm\Events\Span\Span;
use Scoutapm\ScoutApmAgent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use function is_array;
use function is_string;
use function sprintf;

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
     */
    public function onKernelController(ControllerEvent $controllerEvent) : void
    {
        /**
         * @noinspection UnusedFunctionResultInspection
         */
        $this->agent->startSpan(sprintf(
            '%s/%s',
            Span::INSTRUMENT_CONTROLLER,
            $this->controllerNameFromCallable($controllerEvent->getController())
        ));
    }

    /**
     * @throws ReflectionException
     */
    private function controllerNameFromCallable(callable $controller) : string
    {
        if (is_array($controller)) {
            return sprintf('%s::%s', (new ReflectionClass($controller[0]))->getShortName(), $controller[1]);
        }

        if (is_string($controller)) {
            return $controller;
        }

        if ($controller instanceof Closure) {
            return 'closure';
        }

        return 'unknown';
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
