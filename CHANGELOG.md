# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added

- Ability to remove individual trips from the database via the client application ([#4](https://github.com/dasdware/dw-bike-trips/issues/4)).

### Changed

- Changed toggle button text color on history page to highlight color ([#6](https://github.com/dasdware/dw-bike-trips/issues/6)).

## [0.11.0]

This release does not introduce any new functionality. It provides the same content as version 0.10.0 but is built using the new monorepo and release build skript.

## 0.10.0

This release introduces changes to the database table structure. If you have already installed a database for an older version, execute the instructions in `api/migrations/db-0.10.0.sql` to update it to the most recent version.

### Added

- Allow for optional time portion in trip timestamps (Old client project issue [#16](https://github.com/dasdware/dw_bike_trips_client/issues/16); old API project issue [#3](https://github.com/dasdware/dw-bike-trips-api/issues/3)). Old entries that have been added with midnight as time portion are considered to have no time.
- Add the ability to edit individual trips (Old client project issue [#7](https://github.com/dasdware/dw_bike_trips_client/issues/7); old API project issue [#1](https://github.com/dasdware/dw-bike-trips-api/issues/1))

### Changed

- Updated API codebase to current versions (PHP and libraries) (Old API project issue [#2](https://github.com/dasdware/dw-bike-trips-api/issues/2))

### Fixes

- Allow integer values from API in dashboard ([#14](https://github.com/dasdware/dw_bike_trips_client/issues/14))

## 0.9.1 - 2023-02-05

### Added

- Selected [MIT](https://spdx.org/licenses/MIT.html) license for this repository
- Basic support for desktop plattforms ([#11](https://github.com/dasdware/dw_bike_trips_client/issues/11))
- Editing and reverting changes in the upload queue ([#12](https://github.com/dasdware/dw_bike_trips_client/issues/12))

## Changed

- Updated to current Flutter version ([#11](https://github.com/dasdware/dw_bike_trips_client/issues/11))

### Fixes

- Improved error handling ([#9](https://github.com/dasdware/dw_bike_trips_client/issues/9))

## 0.9.0 - 2022-01-26

Initial release version of the dasd.ware BikeTrips Client. Contains the following functionality:

- Management of hosts to which the client can connect.
- Logging in to a selected (active) host.
- Viewing simple statistics in a dashboard.
- Adding new trips with timestamp and distance.

[unreleased]: https://github.com/dasdware/dw-bike-trips/compare/v0.11.0...HEAD
[0.11.0]: https://github.com/dasdware/dw-bike-trips/releases/tag/v0.11.0
