<?php

namespace DW\BikeTrips\API\Schema\Type\Object;

use DW\BikeTrips\API\Schema\Types;
use GraphQL\Type\Definition\ObjectType;

class DashboardDistancesType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'DashboardDistances',
            'description' => 'A collection of distance statistics for the dashboard',
            'fields' => function () {
                return [
                    'today' => Types::nonNull(Types::float()),
                    'thisWeek' => Types::nonNull(Types::float()),
                    'thisMonth' => Types::nonNull(Types::float()),
                    'thisYear' => Types::nonNull(Types::float()),
                    'allTime' => Types::nonNull(Types::float()),
                ];
            }
        ];
        parent::__construct($config);
    }
}
