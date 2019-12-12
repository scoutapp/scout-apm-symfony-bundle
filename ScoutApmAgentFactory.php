<?php

declare(strict_types=1);

namespace Scoutapm\ScoutApmBundle;

use Psr\Container\ContainerInterface;
use Psr\Log\NullLogger;
use Scoutapm\Agent;
use Scoutapm\Config;
use Scoutapm\ScoutApmAgent;

final class ScoutApmAgentFactory
{
    public static function createAgent(ContainerInterface $container) : ScoutApmAgent
    {
        return Agent::fromConfig(
            Config::fromArray([
            ]),
            new NullLogger(),
            null
        );
    }
}
