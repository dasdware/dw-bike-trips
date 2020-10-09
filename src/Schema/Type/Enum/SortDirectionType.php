<?php

namespace DW\BikeTrips\API\Schema\Type\Enum;

use GraphQL\Type\Definition\EnumType;

class SortDirectionType extends EnumType
{
    const DIRECTION_ASC = 'asc';
    const DIRECTION_DESC = 'desc';

    public function __construct()
    {
        $config = [
            'name' => 'SortDirection',
            'values' => [self::DIRECTION_ASC, self::DIRECTION_DESC]
        ];
        parent::__construct($config);
    }
}
