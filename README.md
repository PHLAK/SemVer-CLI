SemVer-CLI
==========

[![Latest Stable Version](https://img.shields.io/packagist/v/PHLAK/SemVer-CLI.svg)](https://packagist.org/packages/PHLAK/SemVer-CLI)
[![Total Downloads](https://img.shields.io/packagist/dt/PHLAK/SemVer-CLI.svg)](https://packagist.org/packages/PHLAK/SemVer-CLI)
[![Author](https://img.shields.io/badge/author-Chris%20Kankiewicz-blue.svg)](https://www.ChrisKankiewicz.com)
[![License](https://img.shields.io/packagist/l/PHLAK/SemVer-CLI.svg)](https://packagist.org/packages/PHLAK/SemVer-CLI)
[![Build Status](https://img.shields.io/travis/PHLAK/SemVer-CLI.svg)](https://travis-ci.org/PHLAK/SemVer-CLI)

CLI app for managing [semantic versioning](http://semver.org) within a project -- by, [Chris Kankiewicz](https://www.ChrisKankiewicz.com)

Introduction
------------

More info coming soon...

Requirements
------------

  - [PHP](https://php.net) >= 7.2

Install with Composer
---------------------

### Per-project

    composer require phlak/semver-cli

> ℹ️ It is recommended to add `vendor/bin` to your `PATH` environment variable
> when installing within a project. Otherwise you will have to call the command 
> with a relative path (i.e. `vendor/bin/semver`) every time.

### Global

    composer global require phlak/semver-cli

> ℹ️ You should add `${COMOPSER_HOME}/vendor/bin` to your `PATH` environment
> variable when installing globally. If you don't you will have to specify the 
> full installation path with every call call.

Usage
-----

    semver init

    semver set:version
    semver set:major
    semver set:minor
    semver set:patch
    semver set:pre-release
    semver set:build

    semver get:version
    semver get:major
    semver get:minor
    semver get:patch
    semver get:pre-release
    semver get:build

    semver increment:major
    semver increment:minor
    semver increment:patch

    ...

Troubleshooting
---------------

Please report bugs to the [GitHub Issue Tracker](https://github.com/PHLAK/SemVer-CLI/issues).

Copyright
---------

This project is liscensed under the [MIT License](https://github.com/PHLAK/SemVer-CLI/blob/master/LICENSE).
