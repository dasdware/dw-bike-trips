<?php

namespace DW\BikeTrips\API\Schema\Type\Query;

use DW\BikeTrips\API\Context;
use DW\BikeTrips\API\Schema\Type\Input\RangeType;
use DW\BikeTrips\API\Schema\Types;
use Error;
use Exception;

class CountTripsQuery
{
    static function appendToFields(&$fields)
    {
        $fields[static::name()] = static::descriptor();
    }

    static function name()
    {
        return 'countTrips';
    }

    static function descriptor()
    {
        return [
            'type' => Types::int(),
            'args' => [
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

        try {
            $count = $context->db
                ->count(
                    "trips",
                    $conditions
                );
        } catch (Exception $e) {
            throw new Error($e->getMessage());
        }

        return $count;
    }
}
