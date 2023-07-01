<?php

namespace DW\BikeTrips\API\Schema\Type\Query;

use DW\BikeTrips\API\Context;
use DW\BikeTrips\API\Schema\Type\Input\RangeType;
use DW\BikeTrips\API\Schema\Types;
use Error;
use Exception;
use Medoo\Medoo;

class DashboardQuery
{
    static function appendToFields(&$fields)
    {
        $fields[static::name()] = static::descriptor();
    }

    static function name()
    {
        return 'dashboard';
    }

    static function descriptor()
    {
        return [
            'type' => Types::dashboard(),
            'args' => [
                'range' => ['type' => Types::range()],
            ],
            'description' => 'Get common (dashboard) statistics for the given time range',
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
            $distances = $context->db
                ->select(
                    'trips',
                    [
                        'today' => Medoo::raw('sum(case when <timestamp> >= curdate() then <distance> else 0 end)'),
                        'yesterday' => Medoo::raw('sum(case when <timestamp> >= adddate(curdate(), interval -1 day) and <timestamp> < curdate() then <distance> else 0 end)'),
                        'thisWeek' => Medoo::raw('sum(case when <timestamp> >= subdate(curdate(), weekday(curdate())) then <distance> else 0 end)'),
                        'lastWeek' => Medoo::raw('sum(case when <timestamp> >= adddate(subdate(curdate(), weekday(curdate())), interval -1 week) and <timestamp> < subdate(curdate(), weekday(curdate())) then <distance> else 0 end)'),
                        'thisMonth' => Medoo::raw('sum(case when <timestamp> >= DATE_SUB(LAST_DAY(NOW()), INTERVAL DAY(LAST_DAY(NOW())) - 1 DAY) then <distance> else 0 end)'),
                        'lastMonth' => Medoo::raw('sum(case when <timestamp> >= adddate(DATE_SUB(LAST_DAY(NOW()), INTERVAL DAY(LAST_DAY(NOW())) - 1 DAY), interval -1 month) and <timestamp> < DATE_SUB(LAST_DAY(NOW()), INTERVAL DAY(LAST_DAY(NOW())) - 1 DAY) then <distance> else 0 end)'),
                        'thisYear' => Medoo::raw('sum(case when <timestamp> >= MAKEDATE(year(now()),1) then <distance> else 0 end)'),
                        'lastYear' => Medoo::raw('sum(case when <timestamp> >= adddate(MAKEDATE(year(now()),1), interval -1 year) and <timestamp> < MAKEDATE(year(now()),1) then <distance> else 0 end)'),
                        'allTime' => Medoo::raw('sum(<distance>)')
                    ],
                    $conditions
                );
            return [
                "distances" => $distances[0]
            ];
        } catch (Exception $e) {
            throw new Error($e->getMessage());
        }
    }
}
