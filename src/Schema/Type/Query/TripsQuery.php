<?php

namespace DW\BikeTrips\API\Schema\Type\Query;

use DateTime;
use DW\BikeTrips\API\Context;
use DW\BikeTrips\API\Schema\Type\Input\LimitType;
use DW\BikeTrips\API\Schema\Type\Input\TripOrderType;
use DW\BikeTrips\API\Schema\Type\Input\RangeType;
use DW\BikeTrips\API\Schema\Types;
use Error;
use Exception;

class TripsQuery
{
    static function appendToFields(&$fields)
    {
        $fields[static::name()] = static::descriptor();
    }

    static function name()
    {
        return 'trips';
    }

    static function descriptor()
    {
        return [
            'type' => Types::listOf(Types::trip()),
            'args' => [
                'limit' => ['type' => Types::limit()],
                'order' => ['type' => Types::tripOrder()],
                'range' => ['type' => Types::range()]
            ],
            'description' => 'Returns a list of trips according to the given arguments',
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

        TripOrderType::buildConditions($args, $conditions);
        LimitType::buildConditions($args, $conditions);

        try {
            $trips = $context->db
                ->select(
                    "trips",
                    ["id", "timestamp", "distance"],
                    $conditions
                );
        } catch (Exception $e) {
            throw new Error($e->getMessage());
        }

        foreach ($trips as &$trip) {
            $trip['timestamp'] = new DateTime($trip['timestamp']);
        }

        return $trips;
    }
}
