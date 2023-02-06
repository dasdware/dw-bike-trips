<?php

namespace DW\BikeTrips\API\Schema\Type\Mutation;

use DateTime;
use DW\BikeTrips\API\Context;
use DW\BikeTrips\API\Schema\Types;
use Exception;
use GraphQL\Error\Error;

class EditTripsMutation
{
    static function appendToFields(&$fields)
    {
        $fields[static::name()] = static::descriptor();
    }

    static function name()
    {
        return 'editTrips';
    }

    static function descriptor()
    {
        return [
            'type' => Types::int(),
            'args' => [
                'trips' => ['type' => Types::listOf(Types::editTrip())]
            ],
            'description' => 'Edit trips in the database',
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
                $updates = [];
                if (isset($trip['timestamp'])) {
                    $updates['timestamp'] = $trip['timestamp']->format(DateTime::ISO8601);
                }
                if (isset($trip['distance'])) {
                    $updates['distance'] = $trip['distance'];
                }

                if (!empty($updates)) {
                    $result = $context->db->update('trips', $updates, ['id' => $trip['id'], 'user_id' => $user_id]);
                    $count += $result->rowCount();
                }
            }

            return $count;
        } catch (Exception $e) {
            throw new Error($e->getMessage());
        }
    }
}
