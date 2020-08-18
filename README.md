SemVer-CLI
==========

<p align="center">
    <a href="https://spectrum.chat/phlaknet"><img src="https://img.shields.io/badge/Join_the-Community-7b16ff.svg?style=for-the-badge" alt="Join our Community"></a>
    <a href="https://github.com/users/PHLAK/sponsorship"><img src="https://img.shields.io/badge/Become_a-Sponsor-cc4195.svg?style=for-the-badge" alt="Become a Sponsor"></a>
    <a href="https://paypal.me/ChrisKankiewicz"><img src="https://img.shields.io/badge/Make_a-Donation-006bb6.svg?style=for-the-badge" alt="One-time Donation"></a>
    <br>
    <a href="https://packagist.org/packages/PHLAK/SemVer-CLI"><img src="https://img.shields.io/packagist/v/PHLAK/SemVer-CLI.svg?style=flat-square" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/PHLAK/SemVer-CLI"><img src="https://img.shields.io/packagist/dt/PHLAK/SemVer-CLI.svg?style=flat-square" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/PHLAK/SemVer-CLI"><img src="https://img.shields.io/packagist/l/PHLAK/SemVer-CLI.svg?style=flat-square" alt="License"></a>
    <a href="https://travis-ci.org/PHLAK/SemVer-CLI"><img src="https://img.shields.io/travis/PHLAK/SemVer-CLI.svg?style=flat-square" alt="Build Status"></a>
    <a href="https://styleci.io/repos/61960030"><img src="https://styleci.io/repos/61960030/shield?branch=master&style=flat-square" alt="StyleCI"></a>
</p>

<p align="center">
    Command line tool for managing <a href="http://semver.org">semantic versioning</a> for a project • Created by <a href="https://www.ChrisKankiewicz.com">Chris Kankiewicz</a> (<a href="https://twitter.com/PHLAK">@PHLAK</a>)
</p>

---

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

### Initialization

To begin, you must initialize semantic versioning within a directory.

    $ semver initialize
    Semantic versioning initialized to 0.1.0

This initializes the version to `0.1.0` by creating a `VERSION` file containing the version in the current directory. 

### Initialize a Specific Version

To initialize to a specific version, pass the version as an argument to the `initialize` command.

    $ semver initialize 1.3.37
    Semantic versioning initialized to 1.3.37

### Parsing Incomplete Versions

Sometimes you may need to initialize with an incomplete version. By default the `initialize` command requires a valid semantic version string. If you want to allow the command to make a "best guess" attempt you can do so with the `--parse` option.

    $ semver initialize 1.2
    Failed to initialize, invalid semantic version string provided

    $ semver initialize --parse 1.2
    Semantic versioning initialized to 1.2.0

### Custom Version File

You can also control the file in which the commands read and write the version to. This is accomplished via the `--file` option. This option can be passed with any command.

    semver --file .version initialize

---

### Setting the Version

You can set the complete version with the `set:version` command.

    semver set:version 1.3.37

Alternately, you may set individual values.

    semver set:major
    semver set:minor
    semver set:patch

> ℹ️ Setting the `major` value will reset the `minor` and `patch` values to `0` and clear the `pre-release` and `build` values.

> ℹ️ Setting the `minor` value will reset the `patch` value to `0` and clear the `pre-release` and `build` values.

> ℹ️ Setting the `patch` value will clear the `pre-release` and `build` values.

    semver set:pre-release
    semver set:build

You may clear the `pre-release` or `build` values with the `clear:*` commands.

    clear:build
    clear:pre-release

---

### Retrieving Values

Get the full version.

    $ semver get:version
    1.3.37

You may also get the version prefixed with `v` with the `--prefix`option.
    
    $ semver get:version --prefix
    v1.3.37

Or retrieve individual values.

    $ semver get:major
    1

    $ semver get:minor
    3

    $ semver get:patch
    37

You may also retrieve the `pre-release` and `build` values. However, since these values can be empty they may return nothing. When the values are empty the exit code will return `201`. 


    $ semver get:pre-release
    $ echo $?
    201

    $ semver get:build
    $ echo $?
    201

If necessary you can get additional output by increasing verbosity.

    $ semver get:pre-release --verbose
    The pre-release value is not set

    $ semver get:build --verbose
    The build value is not set

---

### Incrementing the Version

    semver increment:major
    semver increment:minor
    semver increment:patch

Troubleshooting
---------------

Please report bugs to the [GitHub Issue Tracker](https://github.com/PHLAK/SemVer-CLI/issues).

Copyright
---------

This project is liscensed under the [MIT License](https://github.com/PHLAK/SemVer-CLI/blob/master/LICENSE).
