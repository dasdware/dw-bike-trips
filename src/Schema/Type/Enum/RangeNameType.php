<?php

namespace DW\BikeTrips\API\Schema\Type\Enum;

use GraphQL\Type\Definition\EnumType;

class RangeNameType extends EnumType
{
    const NAME_TODAY = 'today';
    const NAME_THIS_WEEK = 'thisWeek';
    const NAME_THIS_MONTH = 'thisMonth';
    const NAME_THIS_YEAR = 'thisYear';
    const NAME_YESTERDAY = 'yesterday';
    const NAME_LAST_WEEK = 'lastWeek';
    const NAME_LAST_MONTH = 'lastMonth';
    const NAME_LAST_YEAR = 'lastYear';
    const NAME_ALL_TIME = 'allTime';

    public function __construct()
    {
        $config = [
            'name' => 'RangeNameType',
            'values' => [
                self::NAME_TODAY, self::NAME_THIS_WEEK, self::NAME_THIS_MONTH, self::NAME_THIS_YEAR,
                self::NAME_YESTERDAY, self::NAME_LAST_WEEK, self::NAME_LAST_MONTH, self::NAME_LAST_YEAR,
                self::NAME_ALL_TIME
            ]
        ];
        parent::__construct($config);
    }
}
