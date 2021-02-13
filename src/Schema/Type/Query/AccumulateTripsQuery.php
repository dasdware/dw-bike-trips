<?php

namespace DW\BikeTrips\API\Schema\Type\Query;

use DW\BikeTrips\API\Context;
use DW\BikeTrips\API\Schema\Type\Input\AccumulatedTripOrderType;
use DW\BikeTrips\API\Schema\Type\Input\RangeType;
use DW\BikeTrips\API\Schema\Types;
use Error;
use Exception;
use Medoo\Medoo;

class AccumulateTripsQuery
{
    static function appendToFields(&$fields)
    {
        $fields[static::name()] = static::descriptor();
    }

    static function name()
    {
        return 'accumulateTrips';
    }

    static function descriptor()
    {
        return [
            'type' => Types::listOf(Types::accumulatedTrip()),
            'args' => [
                'range' => ['type' => Types::range()],
                'grouping' => ['type' => Types::accumulationGrouping()],
                'order' => ['type' => Types::accumulatedTripOrder()]
            ],
            'description' => 'Returns a list of accumulated trips according to the given arguments',
            'resolve' => function ($rootValue, $args, Context $context) {
                return static::resolve($rootValue, $args, $context);
            }
        ];
    }

    static function resolve($rootValue, $args, Context $context)
    {
        $conditions = [
            'user_id' => $context->current_user_id()
        ];

        if (!empty($args['range'])) {
            RangeType::buildConditions($args['range'], 'timestamp', $conditions);
        }

        AccumulatedTripOrderType::buildConditions($args, $conditions);

        $conditions['GROUP'] = 'name';

        if ($args['grouping'] === 'day') {
            $name = Medoo::raw('YEAR(<timestamp>) * 10000 + MONTH(<timestamp>) * 100 + DAY(<timestamp>)');
        } else if ($args['grouping'] === 'month') {
            $name = Medoo::raw('YEAR(<timestamp>) * 100 + MONTH(<timestamp>)');
        } else if ($args['grouping'] === 'year') {
            $name = Medoo::raw('YEAR(<timestamp>)');
        } else {
            $name = Medoo::raw("'all'");
        }

        try {
            $accumulatedTrips = $context->db
                ->select(
                    "trips",
                    [
                        'name' =>  $name,
                        'begin' => Medoo::raw('MIN(<timestamp>)'),
                        'end' => Medoo::raw('MAX(<timestamp>)'),
                        'distance' => Medoo::raw('SUM(<distance>)'),
                        'count' => Medoo::raw('COUNT(<id>)')
                    ],
                    $conditions
                );

            return $accumulatedTrips;
        } catch (Exception $e) {
            throw new Error($e->getMessage());
        }
    }
}
