<p align="center">
    <img src="semver-cli.svg" alt="SemVer CLI" width="50%">
</p>

<p align="center">
    <a href="https://github.com/PHLAK/SemVer-CLI/discussions"><img src="https://img.shields.io/badge/Join_the-Community-7b16ff.svg?style=for-the-badge" alt="Join our Community"></a>
    <a href="https://github.com/users/PHLAK/sponsorship"><img src="https://img.shields.io/badge/Become_a-Sponsor-cc4195.svg?style=for-the-badge" alt="Become a Sponsor"></a>
    <a href="https://paypal.me/ChrisKankiewicz"><img src="https://img.shields.io/badge/Make_a-Donation-006bb6.svg?style=for-the-badge" alt="One-time Donation"></a>
    <br>
    <a href="https://packagist.org/packages/PHLAK/SemVer-CLI"><img src="https://img.shields.io/packagist/v/PHLAK/SemVer-CLI.svg?style=flat-square" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/PHLAK/SemVer-CLI"><img src="https://img.shields.io/packagist/dt/PHLAK/SemVer-CLI.svg?style=flat-square" alt="Total Downloads"></a>
    <a href="https://github.com/PHLAK/SemVer-CLI/blob/master/LICENSE"><img src="https://img.shields.io/github/license/PHLAK/SemVer-CLI.svg?style=flat-square" alt="License"></a>
    <a href="https://travis-ci.com/PHLAK/SemVer-CLI"><img src="https://img.shields.io/travis/com/PHLAK/SemVer-CLI.svg?style=flat-square" alt="Build Status"></a>
    <a href="https://styleci.io/repos/61960030"><img src="https://styleci.io/repos/61960030/shield?branch=master&style=flat-square" alt="StyleCI"></a>
</p>

<p align="center">
    Command line tool for managing <a href="http://semver.org">semantic versioning</a> for a project
    <br>
    Created by <a href="https://www.ChrisKankiewicz.com">Chris Kankiewicz</a> (<a href="https://twitter.com/PHLAK">@PHLAK</a>)
</p>

---

Requirements
------------

  - [PHP](https://php.net) >= 7.2

Installation
------------

The SemVer CLI can be installed via [Composer](https://getcomposer.org) 
per-project or globally.

#### Per-project

    composer require phlak/semver-cli

When installed to a projcet the `semver` tool is installed to the project's
`vendor/bin` directory.

> ℹ️ It is recommended to add `vendor/bin` to your `PATH` environment variable 
> when installing within a project. Otherwise you will have to call the command 
> with a relative path (i.e. `vendor/bin/semver [arguments]`) every time.

#### Globally

    composer global require phlak/semver-cli

When required globally the `semver` tool will be installed to the global 
`${COMOPSER_HOME}/vendor/bin` directory.

> ℹ️ You should add `${COMOPSER_HOME}/vendor/bin` to your `PATH` environment 
> variable when installing globally. If you don't you will have to specify the 
> full installation path with every call call.

Usage
-----

#### Initialization

To begin, you must initialize semantic versioning within a directory.

    $ semver initialize

This initializes the version to `0.1.0` by creating a `VERSION` file containing 
the version in the current directory.

#### Initialize a Specific Version

To initialize to a specific version, pass the version as an argument to the 
`initialize` command.

    $ semver initialize 1.3.37

#### Initializing Incomplete Versions

Sometimes you may need to initialize semantic versioning with an incomplete 
version. By default the `initialize` command requires a valid semantic version 
string. If you want to allow the command to make a "best guess" attempt you can
do so with the `--parse` option.

    $ semver initialize --parse 1.2

#### Setting Version Values

After initialization you can set (override) the complete version with the 
`set:version` command.

    $ semver set:version 1.3.37

Alternately, you may set individual values.

    $ semver set:major 1
    $ semver set:minor 3
    $ semver set:patch 37
    $ semver set:pre-release beta.5
    $ semver set:build 007

> ℹ️ Setting certain values may affect other values
>   - Setting the `major` value will reset the `minor` and `patch` values to `0`.
>   - Setting the `minor` value will only reset the `patch` value to `0`
>   - Setting the the `major`, `minor` or `patch` value will also clear the 
>     `pre-release` and `build` values

#### Clearing Values

You may clear the `pre-release` or `build` values with the `clear` commands.

    $ semver clear:build
    $ semver clear:pre-release

#### Retrieving Values

At any point after initialization you may get the full version.

    $ semver get:version

To get the version prefixed with `v` (i.e. `v1.3.37`) use the `--prefix` option.
    
    $ semver get:version --prefix

You may also retrieve individual values.

    $ semver get:major
    $ semver get:minor
    $ semver get:patch
    $ semver get:pre-release
    $ semver get:build

If the `pre-release` and `build` values are unset they will return no output by
default. To force output add the `--verbose` option.

    $ semver get:pre-release --verbose
    $ semver get:build --verbose

#### Incrementing the Version

You can increment the version values with the `increment` command.

    $ semver increment:major
    $ semver increment:minor
    $ semver increment:patch

> ℹ️ Incrementing certain values may affect other values
>   - Incrementing the `major` value will reset the `minor` and `patch` values to `0`
>   - Incrementing the `minor` value will only reset the `patch` value to `0`
>   - Incrementing the `major`, `minor` or `patch` value will also clear the 
>     `pre-release` and `build` values

Adapters
--------

The method used for storing version information can be configured with the
`--adapter` option. The following are the available adapters to choose from.

<dl>
  <dt><code>file</code></dt>
  <dd>Stores the version in a regular file in the current directory (default)<dd>

  <dt><code>composer</code></dt>
  <dd>
    Stores the version in the <code>composer.json</code> file under the
    <a href="https://getcomposer.org/doc/04-schema.md#version">version</a> property
  </dd>
</dl>

When using the `file` adapter you can control the file to which commands read
and write the version via the `--file` option. This option takes the name you'd
like to use and will look for a file with that name in the current directory.

    $ semver --file .version get:version

By default the `composer` adapter will look for your `composer.json` file in the
current directory. If your `composer.json` file lives elsewhere you can specify
the path with the `--composer` option.

    $ semver --composer path/to/composer.json increment:major

> ℹ️ Adapter options can be passed passed along with any command.

Configuration
-------------

Instead of passing adapter options with every command you can set these options
in a persistent configuration file. To enable the config create a file in your
project directory with a name of `semver.config.php`. This file MUST be a PHP
file and return an array with with one or more of the followng configuration
options.

<dl>
  <dt><code>adapter</code></dt>
  <dd>
    <p>The storage adapter in which version data will be stored.</p>
    <p>Equivilent to the <code>--adapter</code> option.</p>
  </dd>

  <dt><code>file_name</code></dt>
  <dd>
    <p>Name of the version file when using the file adapter.</p>
    <p>Equvilent to the <code>--file</code> option.</p>
  </dd>

  <dt><code>composer_file</code></dt>
  <dd>
    <p>Path to the composer file when using the composer adpater</p>
    <p>Equvilent to the <code>--composer</code> option.</p>
  </dd>
</dl>

### Examples

```php
<?php

return [
    'adapter' => 'composer',
    'composer_file' => 'some/path/composer.json',
];
```

Changelog
---------

A list of changes can be found on the [GitHub Releases](https://github.com/PHLAK/SemVer-CLI/releases) page.

Troubleshooting
---------------

For general help and support join our [GitHub Discussions](https://github.com/PHLAK/SemVer-CLI/discussions) or reach out on [Twitter](https://twitter.com/PHLAK).

Please report bugs to the [GitHub Issue Tracker](https://github.com/PHLAK/SemVer-CLI/issues).

Copyright
---------

This project is liscensed under the [MIT License](https://github.com/PHLAK/SemVer-CLI/blob/master/LICENSE).
