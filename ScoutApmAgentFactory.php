<?php

declare(strict_types=1);

namespace Scoutapm\ScoutApmBundle;

use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;
use Scoutapm\Agent;
use Scoutapm\Config;
use Scoutapm\ScoutApmAgent;

final class ScoutApmAgentFactory
{
    /** @noinspection PhpUnused */
    public static function createAgent(
        LoggerInterface $logger,
        ?CacheInterface $cache,
        array $agentConfiguration
    ) : ScoutApmAgent {
        return Agent::fromConfig(
            Config::fromArray(array_filter($agentConfiguration)),
            $logger,
            $cache
        );
    }
}
