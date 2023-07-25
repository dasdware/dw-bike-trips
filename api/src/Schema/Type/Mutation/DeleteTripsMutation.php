<?php

namespace DW\BikeTrips\API\Schema\Type\Mutation;

use DateTime;
use DW\BikeTrips\API\Context;
use DW\BikeTrips\API\Schema\Types;
use Exception;
use GraphQL\Error\Error;

class DeleteTripsMutation
{
    static function appendToFields(&$fields)
    {
        $fields[static::name()] = static::descriptor();
    }

    static function name()
    {
        return 'deleteTrips';
    }

    static function descriptor()
    {
        return [
            'type' => Types::int(),
            'args' => [
                'trips' => ['type' => Types::listOf(Types::deleteTrip())]
            ],
            'description' => 'Delete trips from the database',
            'resolve' => function ($rootValue, $args, Context $context) {
                return static::resolve($rootValue, $args, $context);
            }
        ];
    }

    static function resolve($rootValue, $args, Context $context)
    {
        $user_id = $context->current_user_id();

        try {
            $count = 0;

            foreach ($args['trips'] as $trip) {
                $result = $context->db->delete('trips', ['id' => $trip['id'], 'user_id' => $user_id]);
                $count += $result->rowCount();
            }

            return $count;
        } catch (Exception $e) {
            throw new Error($e->getMessage());
        }
    }
}
