<?php

declare(strict_types=1);

namespace Scoutapm\ScoutApmBundle\EventListener;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Logging\LoggerChain;
use Doctrine\DBAL\Logging\SQLLogger;
use Scoutapm\ScoutApmAgent;

final class DoctrineSqlLogger implements SQLLogger
{
    /** @var ScoutApmAgent */
    private $agent;

    public function __construct(ScoutApmAgent $agent)
    {
        $this->agent = $agent;
    }

    /**
     * Note: `$connection` is `null`-able since we cannot guarantee Doctrine is installed here. The DI is configured in
     * such a way that if `doctrine.dbal.default_connection` is invalid, it passes `null`, so we can use that to detect
     * if Doctrine is available and configured.
     */
    public static function register(?Connection $connection, ScoutApmAgent $agent) : self
    {
        $scoutSqlLogger = new self($agent);

        if ($connection === null) {
            // Doctrine is not configured...
            return $scoutSqlLogger;
        }

        $connectionConfiguration = $connection->getConfiguration();

        $currentLogger = $connectionConfiguration->getSQLLogger();

        if ($currentLogger === null) {
            $connectionConfiguration->setSQLLogger($scoutSqlLogger);

            return $scoutSqlLogger;
        }

        $connectionConfiguration->setSQLLogger(new LoggerChain([
            $currentLogger,
            $scoutSqlLogger,
        ]));

        return $scoutSqlLogger;
    }

    /**
     * @inheritDoc
     */
    public function startQuery($sql, ?array $params = null, ?array $types = null)
    {
        $span = $this->agent->startSpan('SQL/Query');
        $span->tag('db.statement', $sql);
    }

    /**
     * @inheritDoc
     */
    public function stopQuery()
    {
        $this->agent->stopSpan();
    }
}
