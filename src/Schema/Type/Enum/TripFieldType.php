<?php

namespace DW\BikeTrips\API\Schema\Type\Enum;

use GraphQL\Type\Definition\EnumType;

class TripFieldType extends EnumType
{
    const FIELD_TIMESTAMP = 'timestamp';
    const FIELD_DISTANCE = 'distance';

    public function __construct()
    {
        $config = [
            'name' => 'TripFieldType',
            'values' => [self::FIELD_TIMESTAMP, self::FIELD_DISTANCE]
        ];
        parent::__construct($config);
    }
}
