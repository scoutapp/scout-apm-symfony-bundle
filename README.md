# Scout Symfony APM Agent

Monitor the performance of PHP Symfony applications with Scout's PHP APM Agent.
Detailed performance metrics and transaction traces are collected once the scout-apm package is installed and configured.

## Requirements

* PHP Version: PHP 7.1+
* Symfony Version: (tbc)

## Quick Start

A Scout account is required. [Signup for Scout](https://scoutapm.com/users/sign_up).

```bash
composer require scoutapp/scout-apm-symfony-bundle
```

Add the bundle to your `config/bundles.php`:

```php
<?php

return [
    // ... other bundles...
    Scoutapm\ScoutApmBundle\ScoutApmBundle::class => ['all' => true],
];
```

### Configuration

Create a file `config/packages/scoutapm.xml` with the contents:

```xml
<?xml version="1.0" ?>

<container xmlns="http://symfony.com/schema/dic/services"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xmlns:scoutapm="http://example.org/schema/dic/scout_apm"
    xsi:schemaLocation="http://symfony.com/schema/dic/services https://symfony.com/schema/dic/services/services-1.0.xsd">

    <scoutapm:config>
        <scoutapm:scoutapm
            name="my application name..."
            key="%env(SCOUT_KEY)%"
            monitor="true"
        />
    </scoutapm:config>
</container>
```

It is recommended not to commit the Scout APM key, instead configure via environment variables, e.g. in `.env.local`:

```
SCOUT_KEY=your_scout_key_here
```

Since the configuration XML above uses `%env(SCOUT_KEY)%` this will be pulled in automatically.

#### Log Messages

Scout uses PSR-3 logging configured by Symfony, so log messages can be found in `var/log/dev.log` in development.

## Documentation

For full installation and troubleshooting documentation, visit our [help site](https://docs.scoutapm.com/#symfony).

## Support

Please contact us at support@scoutapm.com or create an issue in this repo.
