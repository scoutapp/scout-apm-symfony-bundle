<?php

declare(strict_types=1);

namespace Scoutapm\ScoutApmBundle;

use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;
use Scoutapm\Agent;
use Scoutapm\Config;
use Scoutapm\ScoutApmAgent;

final class ScoutApmAgentFactory
{
    public static function createAgent(LoggerInterface $logger, ?CacheInterface $cache) : ScoutApmAgent
    {
        return Agent::fromConfig(
            Config::fromArray([
            ]),
            $logger,
            $cache
        );
    }
}
