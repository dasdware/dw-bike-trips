<?php

namespace DW\BikeTrips\API\Schema\Type;

use DW\BikeTrips\API\Schema\Types;
use GraphQL\Type\Definition\ObjectType;

class TripType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Trip',
            'description' => 'A single trip, defined by a timestamp and a distance',
            'fields' => function () {
                return [
                    'id' => Types::id(),
                    'timestamp' => Types::nonNull(Types::timestamp()),
                    'distance' => Types::nonNull(Types::float())
                ];
            }
        ];
        parent::__construct($config);
    }
}
