<?php

declare(strict_types=1);

namespace Scoutapm\ScoutApmBundle\Tests\Unit\Twig;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Scoutapm\ScoutApmAgent;
use Scoutapm\ScoutApmBundle\Twig\TwigDecorator;
use Twig\Environment as Twig;

/** @covers \Scoutapm\ScoutApmBundle\Twig\TwigDecorator */
final class TwigDecoratorTest extends TestCase
{
    /** @var Twig&MockObject */
    private $twig;
    /** @var ScoutApmAgent&MockObject */
    private $agent;
    /** @var TwigDecorator */
    private $twigDecorator;

    public function setUp() : void
    {
        parent::setUp();

        $this->twig  = $this->createMock(Twig::class);
        $this->agent = $this->createMock(ScoutApmAgent::class);

        $this->twigDecorator = new TwigDecorator($this->twig, $this->agent);
    }

    public function testInstrumentationIsPerformedOnRenderAndValueIsReturned() : void
    {
        self::markTestIncomplete(__METHOD__);
    }

    public function testInstrumentationIsPerformedOnDisplay() : void
    {
        self::markTestIncomplete(__METHOD__);
    }

    public function testAllMethodsAreProxiedToOriginalTwig() : void
    {
        self::markTestIncomplete(__METHOD__);
    }
}
