<?php

namespace DW\BikeTrips\API\Schema\Type\Mutation;

use DateTime;
use DW\BikeTrips\API\Context;
use DW\BikeTrips\API\Schema\Types;
use Exception;
use GraphQL\Error\Error;

class PostTripsMutation
{
    static function appendToFields(&$fields)
    {
        $fields[static::name()] = static::descriptor();
    }

    static function name()
    {
        return 'postTrips';
    }

    static function descriptor()
    {
        return [
            'type' => Types::int(),
            'args' => [
                'trips' => ['type' => Types::listOf(Types::newTrip())]
            ],
            'description' => 'Add new Trips to the database',
            'resolve' => function ($rootValue, $args, Context $context) {
                return static::resolve($rootValue, $args, $context);
            }
        ];
    }

    static function resolve($rootValue, $args, Context $context)
    {
        $user_id = $context->current_user_id();

        $trips = [];
        foreach ($args['trips'] as $trip) {
            $trips[] = [
                'user_id' => $user_id,
                'timestamp' => $trip['timestamp']->format(DateTime::ISO8601),
                'distance' => $trip['distance']
            ];
        }

        try {
            $result = $context->db->insert("trips", $trips);
            return $result->rowCount();
        } catch (Exception $e) {
            throw new Error($e->getMessage());
        }
    }
}
