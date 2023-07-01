<?php

namespace DW\BikeTrips\API\Schema\Type\Object;

use DW\BikeTrips\API\Schema\Types;
use GraphQL\Type\Definition\ObjectType;

class MeType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Me',
            'description' => 'Information about me (the currently logged in user)',
            'fields' => function () {
                return [
                    'email' => Types::string(),
                    'firstname' => Types::string(),
                    'lastname' => Types::string()
                ];
            }
        ];
        parent::__construct($config);
    }
}
