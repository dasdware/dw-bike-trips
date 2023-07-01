<?php

namespace DW\BikeTrips\API\Schema\Type\Query;

use DW\BikeTrips\API\Context;
use DW\BikeTrips\API\Schema\Types;

class ServerInfoQuery
{
    static function appendToFields(&$fields)
    {
        $fields[static::name()] = static::descriptor();
    }

    static function name()
    {
        return 'serverInfo';
    }

    static function descriptor()
    {
        return [
            'type' => Types::serverInfo(),
            'args' => [],
            'description' => 'Fetch information about this BikeTrips server',
            'resolve' => function ($rootValue, $args, Context $context) {
                return static::resolve($rootValue, $args, $context);
            }
        ];
    }

    static function resolve($rootValue, $args, Context $context)
    {
        return $context->server_config;
    }
}
