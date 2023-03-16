<?php

namespace DW\BikeTrips\API\Schema\Type\Input;

use DW\BikeTrips\API\Schema\Type\Enum\TripFieldType;
use DW\BikeTrips\API\Schema\Types;
use GraphQL\Type\Definition\InputObjectType;

class TripOrderType extends InputObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'TripOrder',
            'description' => 'Description of how to order the trips of the returned dataset.',
            'fields' =>  [
                'by' => [
                    'type' => Types::nonNull(Types::tripField()),
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
        $by = TripFieldType::FIELD_TIMESTAMP;
        $direction = 'DESC';

        if (!empty($args['order'])) {
            if (!empty($args['order']['by'])) {
                $by = $args['order']['by'];
            }

            if ($by === 'timestamp') {
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
