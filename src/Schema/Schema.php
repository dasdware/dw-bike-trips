<?php

declare(strict_types=1);

namespace DW\BikeTrips\API\Schema;

// use GraphQL\Type\Schema;
use DW\BikeTrips\API\Schema\Type\QueryType;

class Schema extends \GraphQL\Type\Schema
{
    public function __construct()
    {
        $config = [
            'query' => new QueryType()
        ];
        parent::__construct($config);
    }
}
