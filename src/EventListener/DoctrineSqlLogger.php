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

    public function registerWith(Connection $connection) : void
    {
        $connectionConfiguration = $connection->getConfiguration();

        $currentLogger = $connectionConfiguration->getSQLLogger();

        if ($currentLogger === null) {
            $connectionConfiguration->setSQLLogger($this);

            return;
        }

        $connectionConfiguration->setSQLLogger(new LoggerChain([
            $currentLogger,
            $this,
        ]));
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
