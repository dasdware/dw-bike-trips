<?php

namespace DW\BikeTrips\API\Schema\Type\Object;

use DW\BikeTrips\API\Schema\Types;
use GraphQL\Type\Definition\ObjectType;

class AccumulatedTripType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'AccumulatedTrip',
            'description' => 'A composed trip accumulated over a certain time range',
            'fields' => function () {
                return [
                    'name' => Types::string(),
                    'begin' => Types::nonNull(Types::timestamp()),
                    'end' => Types::nonNull(Types::timestamp()),
                    'count' => Types::nonNull(Types::int()),
                    'distance' => Types::nonNull(Types::float())
                ];
            }
        ];
        parent::__construct($config);
    }
}
