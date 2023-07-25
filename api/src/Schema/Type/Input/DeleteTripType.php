<?php

namespace DW\BikeTrips\API\Schema\Type\Input;

use DW\BikeTrips\API\Schema\Types;
use GraphQL\Type\Definition\InputObjectType;

class DeleteTripType extends InputObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'DeleteTrip',
            'description' => 'Information about an existing trip that should be removed from the database',
            'fields' =>  [
                'id' => Types::nonNull(Types::id()),
            ]
        ];
        parent::__construct($config);
    }
}
