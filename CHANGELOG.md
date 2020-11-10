# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 0.0.4 - 2020-11-10

### Added

- Nothing.

### Changed

- Nothing.

### Deprecated

- [#22](https://github.com/scoutapp/scout-apm-symfony-bundle/pull/22) Require `scout-apm-php:^5.1`
  - Note, if you use any of the `Span::INSTRUMENT_*` constants, these are deprecated, you should now use the
    new `SpanReference::INSTRUMENT_*` constants. We plan to remove the `Span::INSTRUMENT_*` constants with the release
    of `scout-apm-php:6.0.0`.

### Removed

- Nothing.

### Fixed

## 0.0.3 - 2020-09-16

### Added

- Nothing.

### Changed

- [#20](https://github.com/scoutapp/scout-apm-symfony-bundle/pull/20) Multiple changes
  - Replace Travis with GitHub actions
  - Increase matrix spread to test combinations of Symfony 4/5 and Twig 2/3 against PHP 7.1-7.4
  - Upgrade to `scoutapp/scout-apm-php:^5.0` -- *NOTE* there [are upstream BC breaks](https://github.com/scoutapp/scout-apm-php/releases/tag/v5.0.0)
  - Fix missing configuration option in `ConfigurationTest`

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 0.0.2 - 2020-02-18

### Added

- [#16](https://github.com/scoutapp/scout-apm-symfony-bundle/pull/16) Added instrumentation for Twig templating

### Changed

- [#17](https://github.com/scoutapp/scout-apm-symfony-bundle/pull/17) Fixed up static analysis issues

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 0.0.1 - 2020-01-07

### Added

 - [#9](https://github.com/scoutapp/scout-apm-symfony-bundle/pull/9) Instrumentation for controllers (#9)
 - [#8](https://github.com/scoutapp/scout-apm-symfony-bundle/pull/8) Set up CI build for bundle (#8)
 - [#7](https://github.com/scoutapp/scout-apm-symfony-bundle/pull/7) Configure framework version automatically for agent (#7)
 - [#13](https://github.com/scoutapp/scout-apm-symfony-bundle/pull/13) Instrumentation for Doctrine DBAL queries, if configured (#13)

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.
