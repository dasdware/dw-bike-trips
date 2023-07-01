<?php

namespace DW\BikeTrips\API\Schema\Type\Query;

use DW\BikeTrips\API\Context;
use DW\BikeTrips\API\Schema\Types;

class LoginQuery
{
    static function appendToFields(&$fields)
    {
        $fields[static::name()] = static::descriptor();
    }

    static function name()
    {
        return 'login';
    }

    static function descriptor()
    {
        return [
            'type' => Types::loggedIn(),
            'args' => [
                'email' => ['type' => Types::nonNull(Types::string())],
                'password' => ['type' => Types::nonNull(Types::string())]
            ],
            'description' => 'Log the user with the given credentials',
            'resolve' => function ($rootValue, $args, Context $context) {
                return static::resolve($rootValue, $args, $context);
            }
        ];
    }

    static function resolve($rootValue, $args, Context $context)
    {
        $token = $context->login($args['email'], $args['password']);
        return ['token' => $token];
    }
}
