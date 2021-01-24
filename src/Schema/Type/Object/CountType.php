<?php

namespace DW\BikeTrips\API\Schema\Type\Object;

use DW\BikeTrips\API\Schema\Types;
use GraphQL\Type\Definition\ObjectType;

class CountType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Count',
            'description' => 'A result of a countTrips operation, returns the count and the date range of available trips',
            'fields' => function () {
                return [
                    'count' => Types::nonNull(Types::int()),
                    'begin' => Types::timestamp(),
                    'end' => Types::timestamp()
                ];
            }
        ];
        parent::__construct($config);
    }
}
