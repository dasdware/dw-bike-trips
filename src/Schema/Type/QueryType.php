<?php

namespace DW\BikeTrips\API\Schema\Type;

use DW\BikeTrips\API\Schema\Type\Query\CountTripsQuery;
use DW\BikeTrips\API\Schema\Type\Query\DashboardQuery;
use DW\BikeTrips\API\Schema\Type\Query\LoginQuery;
use DW\BikeTrips\API\Schema\Type\Query\MeQuery;
use DW\BikeTrips\API\Schema\Type\Query\ServerInfoQuery;
use DW\BikeTrips\API\Schema\Type\Query\TripsQuery;
use GraphQL\Type\Definition\ObjectType;
use DW\BikeTrips\API\Schema\Types;

class QueryType extends ObjectType
{
    public function __construct()
    {
        $fields = [];

        CountTripsQuery::appendToFields($fields);
        DashboardQuery::appendToFields($fields);
        LoginQuery::appendToFields($fields);
        MeQuery::appendToFields($fields);
        ServerInfoQuery::appendToFields($fields);
        TripsQuery::appendToFields($fields);

        $config = [
            'name' => 'Query',
            'fields' => $fields
        ];

        parent::__construct($config);
    }
}
