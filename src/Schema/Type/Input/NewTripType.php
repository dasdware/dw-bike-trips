<?php

namespace DW\BikeTrips\API\Schema\Type\Input;

use DW\BikeTrips\API\Schema\Types;
use GraphQL\Type\Definition\InputObjectType;

class NewTripType extends InputObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'NewTrip',
            'description' => 'Information about a new trip that should be added to the database',
            'fields' =>  [
                'timestamp' => ['type' => Types::nonNull(Types::timestamp())],
                'distance' => ['type' => Types::nonNull(Types::float())]
            ]
        ];
        parent::__construct($config);
    }
}
