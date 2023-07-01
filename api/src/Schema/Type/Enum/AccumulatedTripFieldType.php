<?php

namespace DW\BikeTrips\API\Schema\Type\Enum;

use GraphQL\Type\Definition\EnumType;

class AccumulatedTripFieldType extends EnumType
{
    const FIELD_NAME = 'name';
    const FIELD_BEGIN = 'begin';
    const FIELD_END = 'end';
    const FIELD_COUNT = 'count';
    const FIELD_DISTANCE = 'distance';

    public function __construct()
    {
        $config = [
            'name' => 'AccumulatedTripField',
            'values' => [
                self::FIELD_NAME, self::FIELD_BEGIN, self::FIELD_END,
                self::FIELD_COUNT, self::FIELD_DISTANCE
            ]
        ];
        parent::__construct($config);
    }
}
