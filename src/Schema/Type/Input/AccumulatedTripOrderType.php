<?php

namespace DW\BikeTrips\API\Schema\Type\Input;

use DW\BikeTrips\API\Schema\Types;
use GraphQL\Type\Definition\InputObjectType;

class AccumulatedTripOrderType extends InputObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'AccumulatedTripOrderType',
            'description' => 'Description of how to order the accumulated trips of the returned dataset.',
            'fields' =>  [
                'by' => [
                    'type' => Types::nonNull(Types::accumulatedTripField()),
                    'description' => 'The field that should be used for ordering.'
                ],
                'direction' => [
                    'type' => Types::sortDirection(),
                    'description' => 'The direction in which to order the returned dataset.'
                ]
            ]
        ];
        parent::__construct($config);
    }

    static function buildConditions($args, &$conditions)
    {
        $by = 'name';
        $direction = 'DESC';

        if (!empty($args['order'])) {
            if (!empty($args['order']['by'])) {
                $by = $args['order']['by'];
            }

            if ($by === 'name' || $by === 'begin' || $by === 'end') {
                $direction = 'DESC';
            } else {
                $direction = 'ASC';
            }
            if (!empty($args['order']['direction'])) {
                $direction = strtoupper($args['order']['direction']);
            }
        }

        $conditions["ORDER"] = [$by => $direction];
    }
}
