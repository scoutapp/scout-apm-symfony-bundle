<?php

declare(strict_types=1);

namespace Scoutapm\ScoutApmBundle\Tests\Unit\EventListener;

use PHPUnit\Framework\TestCase;

/** @covers \Scoutapm\ScoutApmBundle\EventListener\DoctrineSqlLogger */
final class DoctrineSqlLoggerTest extends TestCase
{
    public function testRegisterInjectsSqlLoggerAsChainWhenLoggerAlreadySetButNotAChain() : void
    {
        self::markTestIncomplete(__METHOD__); // @todo
    }

    public function testRegisterAddsSqlLoggerWhenLoggerChainAlreadySet() : void
    {
        self::markTestIncomplete(__METHOD__); // @todo
    }

    public function testRegisterAddsSqlLoggerWhenNoLoggerHasBeenSet() : void
    {
        self::markTestIncomplete(__METHOD__); // @todo
    }

    public function testStartQueryStartsAgentSpanAndTagsQuery() : void
    {
        self::markTestIncomplete(__METHOD__); // @todo
    }

    public function testStopQueryStopsSpan() : void
    {
        self::markTestIncomplete(__METHOD__); // @todo
    }
}
