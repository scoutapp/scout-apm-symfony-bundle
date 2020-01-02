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
     *
     * @noinspection PhpUnused
     */
    public function onKernelController(ControllerEvent $controllerEvent) : void
    {
        /** @noinspection UnusedFunctionResultInspection */
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
            /**
             * @link https://github.com/vimeo/psalm/commit/e68fd02e805dffd503f2ce578a2ecae12c11b8af
             * Update our Psalm version when possible.
             *
             * @psalm-suppress ArgumentTypeCoercion Reported this and it's already fixed in Psalm's dev-master
             */
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
