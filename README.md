# dasd.ware BikeTrips

This project allows you to manage your history of bike trips in a self-hosted database. The project contains of two individual parts: the client that provides the UI to login, post and manipulate trips; and an API that takes care of the client's requests and stores the trips in a database.

The next sections give a more detailed overview of the components.

> This project is highly experimental and more of an excercise in teaching myself various technologies and concepts. It cannot - and most likely, never will - be considered production ready.

## Client (Dart; Flutter)

A client for hosts supporting the dw-bike-trips-api GraphQL interface. It is implemented in Flutter.

## API (PHP)

This is the GraphQL Server that provides data about your bike trips. A bike trip consists of a timestamp and a distance. At the moment, it supports the following capabilities:

- **Login with user email and password**: Using the `login` query with a email address and a password, you can retrieve a JWT that can be used to authorize further queries and mutations.

- **Getting user information**: Using the `me` query, you can request information about the user that is identified by the given JWT.

- **Querying trips in the database**: Using the `trips` query you can retrieve a selection of the trips stored in the database.

- **Posting new trips**: Using the `postTrips` query, you can add new bike trips to the database.

### Installation

1. Checkout this repository and copy its files to the webserver it should be served from. At the moment, only Apache is supported.

2. Install the dependencies via [Composer](https://getcomposer.org/):

   composer install

3. Create a SQL database for your bike trips and import the database structure from the file `database.sql`.

4. Copy the file `config.sample.php` and rename the copy to `config.php`. Then adjust the `<...>` option values:

   - `server name`: The name the server should use to identify itself to clients.
   - `database type`: The database type. Supported database types can be found in the [documentation for the Medoo framework](https://medoo.in/api/new).
   - `database name`: The name of the database you just created in step 3.
   - `database server`: The server of the database.
   - `database user`: The user that should be used.
   - `database user password`: The password for the user that should be used.
   - `jwt signing key`: The key that should be used for signing JWTs. It should be a random string with sufficient length (e.g. `128`). There are online services for generating these, [here is an example](http://www.unit-conversion.info/texttools/random-string-generator/).

   Aside tfrom that, you can also change the hashing algorithm for login and JWT signing (by default `SHA-256`) and the expiration time for JWTs (by default `7200` seconds).

After these steps, the server should already be able to run. However, in order to use it, you actually need to create a new user in the database. For that, add an entry to the `users` table in the database and fill in the fields `email`, `password`, `firstname` and `lastname` appropriately. The `password` field must be hashed with the algorithm that login hashing algorithm defined in `config.php`.
