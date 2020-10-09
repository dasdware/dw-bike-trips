<?php

namespace DW\BikeTrips\API\Schema\Type;

use DW\BikeTrips\API\Schema\Type\Query\LoginQuery;
use DW\BikeTrips\API\Schema\Type\Query\TripsQuery;
use GraphQL\Type\Definition\ObjectType;
use DW\BikeTrips\API\Schema\Types;

class QueryType extends ObjectType
{
    public function __construct()
    {
        $fields = [
            'accumulate' => [
                'type' => Types::listOf(Types::accumulatedTrip()),
                'description' => 'Returns a list of accumulated trips according to the given arguments'
            ]
        ];

        TripsQuery::appendToFields($fields);
        LoginQuery::appendToFields($fields);

        $config = [
            'name' => 'Query',
            'fields' => $fields
        ];

        parent::__construct($config);
    }
}
