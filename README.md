# Playground CMS Resource

[![Playground CI Workflow](https://github.com/gammamatrix/playground-cms-resource/actions/workflows/ci.yml/badge.svg?branch=develop)](https://raw.githubusercontent.com/gammamatrix/playground-cms-resource/testing/develop/testdox.txt)
[![Test Coverage](https://raw.githubusercontent.com/gammamatrix/playground-cms-resource/testing/develop/coverage.svg)](tests)
[![PHPStan Level 9 src and tests](https://img.shields.io/badge/PHPStan-level%209-brightgreen)](.github/workflows/ci.yml#L120)

The `playground-cms-resource` Laravel package.

This package provides an API and a Blade UI for interacting with the [Playground CMS](https://github.com/gammamatrix/playground-cms), a Content Management System for Laravel.

If you need a CMS without a UI, then have a look at [Playground CMS API.](https://github.com/gammamatrix/playground-cms-api)

## Documentation

Read more on using [Playground CMS Resource at Read the Docs: Playground Documentation.](https://gammamatrix-playground.readthedocs.io/en/develop/components/cms.html)

### Postman

A postman collection is provided in the repository: [postman-playground-cms-resource.json.](postman-playground-cms-resource.json)
- This same collection is viewable on the [Postman: GammaMatrix Playground workspace.](https://www.postman.com/gammamatrix/workspace/playground/documentation/1185343-1e4a5656-d4e0-45b2-8f4e-daad7a6ee2b1)

### Swagger

This application provides Swagger documentation: [swagger.json](swagger.json).
- The endpoint models support locks, trash with force delete, restoring, revisions and more.
- Index endpoints support advanced query filtering.

Swagger API Documentation is built with npm.
- npm is only needed to generate documentation and is not needed to operate the CMS UI and API Resource.

See [package.json](package.json) requirements.

Install npm.

```sh
npm install
```

Build the documentation to generate the [swagger.json](swagger.json) configuration.

```sh
npm run docs
```

Documentation
- Preview [swagger.json on the Swagger Editor UI.](https://editor.swagger.io/?url=https://raw.githubusercontent.com/gammamatrix/playground-cms-resource/develop/swagger.json)
- Preview [swagger.json on the Redocly Editor UI.](https://redocly.github.io/redoc/?url=https://raw.githubusercontent.com/gammamatrix/playground-cms-resource/develop/swagger.json)

## Installation

You can install the package via composer:

```bash
composer require gammamatrix/playground-cms-resource
```

## `artisan about`

Playground provides information in the `artisan about` command.

<!-- <img src="resources/docs/artisan-about-playground-cms-resource.png" alt="screenshot of artisan about command with Playground CMS Resource."> -->

## Configuration

You can publish the config file with:

```bash
php artisan vendor:publish --provider="Playground\Cms\Resource\ServiceProvider" --tag="playground-config"
```

All routes are enabled by default. They may be disabled via enviroment variable or the configuration.

See the contents of the published config file: [config/playground-cms-resource.php](config/playground-cms-resource.php)

You can publish the routes file with:
```bash
php artisan vendor:publish --provider="Playground\Cms\Resource\ServiceProvider" --tag="playground-routes"
```
- The routes while be published in a folder at `routes/playground-cms-resource`

### Environment Variables

If you are unable or do not want to publish [configuration files for this package](config/playground-cms-resource.php),
you may override the options via system environment variables.

Information on [environment variables is available on the wiki for this package](https://github.com/gammamatrix/playground-cms-resource/wiki/Environment-Variables)


## Migrations

This package requires the migrations in [playground-cms](https://github.com/gammamatrix/playground-cms) a Laravel package.

## Cloc

```sh
composer cloc
```

```
➜  playground-cms-resource git:(develop) ✗ composer cloc
> cloc --exclude-dir=node_modules,output,vendor .
     176 text files.
     117 unique files.
      60 files ignored.

github.com/AlDanial/cloc v 1.98  T=0.20 s (594.0 files/s, 101004.7 lines/s)
-------------------------------------------------------------------------------
Language                     files          blank        comment           code
-------------------------------------------------------------------------------
JSON                             4              0              0          10577
PHP                             70            703           1058           3837
YAML                            24              5              2           2724
Blade                           13             60              7            527
XML                              3              0              5            222
Markdown                         2             48              1            103
INI                              1              3              0             12
-------------------------------------------------------------------------------
SUM:                           117            819           1073          18002
-------------------------------------------------------------------------------
```

## PHPStan

Tests at level 9 on:
- `config/`
- `database/`
- `resources/views/`
- `routes/`
- `src/`
- `tests/Feature/`
- `tests/Unit/`

```sh
composer analyse
```

## Coding Standards

```sh
composer format
```

## Tests

```sh
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.
