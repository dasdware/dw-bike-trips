<?php

namespace DW\BikeTrips\API\Schema\Type\Object;

use DW\BikeTrips\API\Schema\Types;
use GraphQL\Type\Definition\ObjectType;

class LoggedInType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'LoggedIn',
            'description' => 'Result of a login operation. Contains the JWT for further authentication',
            'fields' => function () {
                return [
                    'token' => Types::nonNull(Types::string())
                ];
            }
        ];
        parent::__construct($config);
    }
}
