<?php

declare(strict_types=1);

namespace Scoutapm\ScoutApmBundle\Tests\Unit\EventListener;

use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Scoutapm\ScoutApmAgent;
use Scoutapm\ScoutApmBundle\EventListener\InstrumentationListener;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/** @covers \Scoutapm\ScoutApmBundle\EventListener\InstrumentationListener */
final class InstrumentationListenerTest extends TestCase
{
    /** @var ScoutApmAgent&MockObject */
    private $agent;

    /** @var InstrumentationListener */
    private $listener;

    public function setUp() : void
    {
        parent::setUp();

        $this->agent = $this->createMock(ScoutApmAgent::class);

        $this->listener = new InstrumentationListener($this->agent);
    }

    /**
     * @return callable[][]|string[][]
     *
     * @psalm-return array<string, array{0: callable, 1: string}>
     */
    public function controllerCallableTypeProvider() : array
    {
        return [
            'array-class-string' => [[self::class, 'setUpBeforeClass'], 'InstrumentationListenerTest::setUpBeforeClass'],
            'array-instance' => [[$this, 'setUp'], 'InstrumentationListenerTest::setUp'],
            'string' => ['file_get_contents', 'file_get_contents'],
            'closure' => [
                static function () : void {
                },
                'closure',
            ],
            'invokable' => [
                new class () {
                    public function __invoke() : void
                    {
                    }
                },
                'unknown',
            ],
        ];
    }

    /**
     * @throws Exception
     *
     * @dataProvider controllerCallableTypeProvider
     */
    public function testControllerNameIsSentOnControllerEvent(callable $controller, string $expectedName) : void
    {
        $controllerEvent = new ControllerEvent(
            $this->createMock(HttpKernelInterface::class),
            $controller,
            new Request(),
            null
        );

        $this->agent->expects(self::once())
            ->method('startSpan')
            ->with('Controller/' . $expectedName);

        $this->listener->onKernelController($controllerEvent);
    }
}
