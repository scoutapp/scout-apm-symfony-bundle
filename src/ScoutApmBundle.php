<?php

declare(strict_types=1);

namespace Scoutapm\ScoutApmBundle;

use Doctrine\DBAL\Connection;
use Scoutapm\ScoutApmBundle\EventListener\DoctrineSqlLogger;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class ScoutApmBundle extends Bundle
{
    public function boot() : void
    {
        if (! $this->container->has('doctrine.dbal.default_connection')) {
            return;
        }

        /** @var DoctrineSqlLogger $sqlLogger */
        $sqlLogger = $this->container->get(DoctrineSqlLogger::class);
        /** @var Connection $connection */
        $connection = $this->container->get('doctrine.dbal.default_connection');

        $sqlLogger->registerWith($connection);
    }
}
