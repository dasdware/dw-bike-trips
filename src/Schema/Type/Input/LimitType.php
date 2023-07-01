<?php

namespace DW\BikeTrips\API\Schema\Type\Input;

use DW\BikeTrips\API\Schema\Types;
use GraphQL\Type\Definition\InputObjectType;

class LimitType extends InputObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Limit',
            'description' => 'Description of the subwindow of entries that should be returned.',
            'fields' =>  [
                'count' => [
                    'type' => Types::nonNull(Types::int()),
                    'description' => 'Number of entries in the subwindow.'
                ],
                'offset' => [
                    'type' => Types::int(),
                    'description' => 'Index (zero-based) of the first entry in the subwindow.'
                ]
            ]
        ];
        parent::__construct($config);
    }

    static function buildConditions($args, &$conditions)
    {
        $count = 20;
        $offset = 0;

        if (!empty($args['limit'])) {
            $count = $args['limit']['count'];
            if (!empty($args['limit']['offset'])) {
                $offset = $args['limit']['offset'];
            }
        }

        $conditions["LIMIT"] = [$offset, $count];
    }
}
