<?php

declare(strict_types=1);

namespace Scoutapm\ScoutApmBundle\EventListener;

use Doctrine\DBAL\Logging\LoggerChain;
use Doctrine\DBAL\Logging\SQLLogger;
use Doctrine\ORM\EntityManagerInterface;
use Scoutapm\ScoutApmAgent;

final class DoctrineSqlLogger implements SQLLogger
{
    /** @var ScoutApmAgent */
    private $agent;

    public function __construct(ScoutApmAgent $agent)
    {
        $this->agent = $agent;
    }

    public static function register(EntityManagerInterface $entityManager, ScoutApmAgent $agent) : self
    {
        $scoutSqlLogger = new self($agent);

        $entityManagerConfiguration = $entityManager->getConfiguration();

        $currentLogger = $entityManagerConfiguration->getSQLLogger();

        if ($currentLogger === null) {
            $entityManagerConfiguration->setSQLLogger($scoutSqlLogger);

            return $scoutSqlLogger;
        }

        // @todo if already a Logger chain, just add scoutSqlLogger

        $entityManagerConfiguration->setSQLLogger(new LoggerChain([
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
