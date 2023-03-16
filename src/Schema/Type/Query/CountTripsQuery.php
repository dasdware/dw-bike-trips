<?php

namespace DW\BikeTrips\API\Schema\Type\Query;

use DateTime;
use DW\BikeTrips\API\Context;
use DW\BikeTrips\API\Schema\Type\Input\RangeType;
use DW\BikeTrips\API\Schema\Types;
use DW\BikeTrips\API\Utils\Timestamp;
use Error;
use Exception;
use Medoo\Medoo;

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
            'type' => Types::count(),
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
                ->select(
                    "trips",
                    [
                        "count" => Medoo::raw('COUNT(<id>)'),
                        "begin" => Medoo::raw('MIN(<timestamp>)'),
                        "end" => Medoo::raw('MAX(<timestamp>)')
                    ],
                    $conditions
                );

            // TODO: Think about correct calculation of optional time part
            return [
                'count' => intval($count[0]['count']),
                'begin' => (!empty($count[0]['begin'])) ? Timestamp::fromDatabase($count[0]['begin'], true) : null,
                'end' => (!empty($count[0]['end'])) ? Timestamp::fromDatabase($count[0]['end'], true) : null
            ];
        } catch (Exception $e) {
            throw new Error($e->getMessage());
        }
    }
}
