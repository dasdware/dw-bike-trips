<?php

declare(strict_types=1);

namespace DW\BikeTrips\API\Schema\Queries;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class EchoQuery extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'fields' => [
                'echo' => [
                    'type' => Type::string(),
                    'args' => [
                        'message' => Type::nonNull(Type::string())
                    ],
                    'resolve' => function ($rootValue, $args) {
                        return $rootValue['prefix'] . $args['message'];
                    }
                ]
            ]
        ]);
    }
}
