<?php

namespace DW\BikeTrips\API\Schema\Type\Object;

use DW\BikeTrips\API\Schema\Types;
use GraphQL\Type\Definition\ObjectType;

class DashboardType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Dashboard',
            'description' => 'A collection of statistics for the dashboard',
            'fields' => function () {
                return [
                    'distances' => Types::dashboardDistances()
                ];
            }
        ];
        parent::__construct($config);
    }
}
