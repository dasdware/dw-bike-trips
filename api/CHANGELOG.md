# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

Nothing yet!

## [v0.10.0]

This release introduces changes to the database table structure. If you have already installed a database for an older version, execute the instructions in `migrations/db-0.10.0.sql` to update it to the most recent version.

### Added

- Allow for optional time portion in trip timestamps ([#3](https://github.com/dasdware/dw-bike-trips-api/issues/3)). Old entries that have been added with midnight as time portion are considered to have no time.
- Selected [MIT](https://spdx.org/licenses/MIT.html) license for this repository
- Capability to edit trips in the database ([#1](https://github.com/dasdware/dw-bike-trips-api/issues/1))

### Changed

- Updated codebase to current versions (PHP and libraries) ([#2](https://github.com/dasdware/dw-bike-trips-api/issues/2))

## [0.9.0] - 2022-01-28

Initial release version of the dasd.ware BikeTrips API. API Versions `X.Y.*` are compatible with Client versions `X.Y.*`. Therefore, if only the last number in the API version changes, the Client does not need to be updated.

[unreleased]: https://github.com/dasdware/dw-bike-trips-api/compare/v0.10.0...HEAD
[0.10.0]: https://github.com/dasdware/dw-bike-trips-api/releases/tag/v0.10.0
[0.9.0]: https://github.com/dasdware/dw-bike-trips-api/releases/tag/v0.9.0
