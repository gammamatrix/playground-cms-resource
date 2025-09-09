# Playground: CMS Resource

[![Playground CI Workflow](https://github.com/gammamatrix/playground-cms-resource/actions/workflows/ci.yml/badge.svg?branch=develop)](https://raw.githubusercontent.com/gammamatrix/playground-cms-resource/testing/develop/testdox.txt)
[![Test Coverage](https://raw.githubusercontent.com/gammamatrix/playground-cms-resource/testing/develop/coverage.svg)](tests)
[![PHPStan Level 10](https://img.shields.io/badge/PHPStan-level%2010-brightgreen)](.github/workflows/ci.yml#L128)

Playground: CMS Resource

This package provides an API and a Blade UI for interacting with the [Playground: CMS](https://github.com/gammamatrix/playground-cms), a model package for Laravel.

If you need a JSON API without a UI, then have a look at [Playground: CMS API.](https://github.com/gammamatrix/playground-cms-api)

## Documentation

Read more on using [Playground: CMS Resource at Read the Docs: Playground Documentation](https://gammamatrix-playground.readthedocs.io/en/develop/components/cms.html)

### Postman

A postman collection is provided in the repository: [postman-playground-cms-resource.json.](postman-playground-cms-resource.json)
- This same collection is viewable on the [Postman: GammaMatrix Playground Workspace.](https://www.postman.com/gammamatrix/workspace/playground/documentation/1185343-1e4a5656-d4e0-45b2-8f4e-daad7a6ee2b1)

### OpenAPI

This application provides OpenAPI documentation: [openapi.json](openapi.json).
- The endpoint models support locks, trash with force delete, restoring, revisions and more.
- Index endpoints support advanced query filtering.

OpenAPI API Documentation is built with npm using Redocly.
- npm is only needed to generate documentation and is not needed to operate the Playground: CMS Resource API.

See [package.json](package.json) requirements.

Install npm.

```sh
npm install
```

Build the documentation to generate the [openapi.json](openapi.json) configuration.

```sh
npm run docs
```

Documentation
- Preview [openapi.json on the Redocly Editor UI.](https://redocly.github.io/redoc/?url=https://raw.githubusercontent.com/gammamatrix/playground-cms-resource/develop/openapi.json)

## Installation

You can install the package via composer:

```bash
composer require gammamatrix/playground-cms-resource
```

## `artisan about`

Playground provides information in the `artisan about` command.

<!-- <img src="resources/docs/artisan-about-playground-cms-resource.png" alt="screenshot of artisan about command with Playground: CMS Resource."> -->

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
     237 text files.
     226 unique files.
     112 files ignored.

github.com/AlDanial/cloc v 2.06  T=0.09 s (2383.2 files/s, 272248.4 lines/s)
     239 text files.
     227 unique files.
     122 files ignored.

github.com/AlDanial/cloc v 2.06  T=0.10 s (2191.0 files/s, 380588.8 lines/s)
-------------------------------------------------------------------------------
Language                     files          blank        comment           code
-------------------------------------------------------------------------------
JSON                            83              0              0          26082
PHP                             83            998           1360           4089
YAML                            29              5              0           3053
Blade                           20            105              0           2768
XML                              8              0              7            765
Markdown                         3             55              1            129
INI                              1              3              0             12
-------------------------------------------------------------------------------
SUM:                           227           1166           1368          36898
-------------------------------------------------------------------------------
```

## PHPStan

Tests at level 10 on:
- `config/`
- `lang/`
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

## Testing

Run unit tests:
```sh
composer test
```

Run unit and feature tests:
```sh
composer test-dev
```

Run unit and feature tests in parallel:
```sh
composer test-parallel
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
