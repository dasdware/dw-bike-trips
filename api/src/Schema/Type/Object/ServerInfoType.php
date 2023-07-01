<?php

namespace DW\BikeTrips\API\Schema\Type\Object;

use DW\BikeTrips\API\Schema\Types;
use GraphQL\Type\Definition\ObjectType;

class ServerInfoType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'ServerInfo',
            'description' => 'Information about this server',
            'fields' => function () {
                return [
                    'name' => Types::string()
                ];
            }
        ];
        parent::__construct($config);
    }
}
