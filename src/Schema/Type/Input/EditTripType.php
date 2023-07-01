<?php

namespace DW\BikeTrips\API\Schema\Type\Input;

use DW\BikeTrips\API\Schema\Types;
use GraphQL\Type\Definition\InputObjectType;

class EditTripType extends InputObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'EditTrip',
            'description' => 'Information about a new trip that should be updated in the database',
            'fields' =>  [
                'id' => Types::nonNull(Types::id()),
                'timestamp' => ['type' => Types::timestamp()],
                'distance' => ['type' => Types::float()]
            ]
        ];
        parent::__construct($config);
    }
}
