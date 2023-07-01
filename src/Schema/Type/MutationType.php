<?php

namespace DW\BikeTrips\API\Schema\Type;

use DW\BikeTrips\API\Schema\Type\Mutation\EditTripsMutation;
use DW\BikeTrips\API\Schema\Type\Mutation\PostTripsMutation;
use GraphQL\Type\Definition\ObjectType;

class MutationType extends ObjectType
{
    public function __construct()
    {
        $fields = [];

        PostTripsMutation::appendToFields($fields);
        EditTripsMutation::appendToFields($fields);

        $config = [
            'name' => 'Mutation',
            'fields' => $fields
        ];

        parent::__construct($config);
    }
}
