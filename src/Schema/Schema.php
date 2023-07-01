<?php

declare(strict_types=1);

namespace DW\BikeTrips\API\Schema;

use DW\BikeTrips\API\Schema\Type\MutationType;
use DW\BikeTrips\API\Schema\Type\QueryType;

class Schema extends \GraphQL\Type\Schema
{
    public function __construct()
    {
        $config = [
            'query' => new QueryType(),
            'mutation' => new MutationType()
        ];
        parent::__construct($config);
    }
}
