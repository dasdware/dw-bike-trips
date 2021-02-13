<?php

namespace DW\BikeTrips\API\Schema\Type\Enum;

use GraphQL\Type\Definition\EnumType;

class AccumulationGroupingType extends EnumType
{
    const NAME_ALL = 'all';
    const NAME_YEAR = 'year';
    const NAME_MONTH = 'month';
    const NAME_DAY = 'day';

    public function __construct()
    {
        $config = [
            'name' => 'AccumulationGroupingType',
            'values' => [
                self::NAME_ALL, self::NAME_YEAR, self::NAME_MONTH, self::NAME_DAY
            ]
        ];
        parent::__construct($config);
    }
}
