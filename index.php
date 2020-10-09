<?php

require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';

use DW\BikeTrips\API\Context;
use GraphQL\Server\StandardServer;
use Medoo\Medoo;

use DW\BikeTrips\API\Schema\Schema;

function open_database()
{
    global $database_config;
    return new Medoo($database_config);
}

try {
    $schema = new Schema();
    $context = new Context(open_database());

    $server = new StandardServer([
        'schema' => $schema,
        'context' => $context
    ]);
    $server->handleRequest();
} catch (Exception $e) {
    StandardServer::send500Error($e);
}
