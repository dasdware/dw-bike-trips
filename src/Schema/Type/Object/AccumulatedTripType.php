<?php

namespace DW\BikeTrips\API\Schema\Type\Object;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class AccumulatedTripType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'AccumulatedTrip',
            'description' => 'A composed trip accumulated over a certain time range',
            'fields' => function () {
                return [
                    'begin' => Type::nonNull(Type::string()),
                    'end' => Type::nonNull(Type::string()),
                    'distance' => Type::nonNull(Type::float())
                ];
            }
        ];
        parent::__construct($config);
    }
}
