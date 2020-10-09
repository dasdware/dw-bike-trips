<?php

namespace DW\BikeTrips\API\Schema\Type\Scalar;

use DateTime;
use Exception;
use GraphQL\Error\Error;
use GraphQL\Language\AST\StringValueNode;
use GraphQL\Type\Definition\CustomScalarType;
use GraphQL\Utils\Utils;

class TimestampType extends CustomScalarType
{
    public function __construct()
    {
        parent::__construct([
            'serialize' => [__CLASS__, 's_serialize'],
            'parseValue' => [__CLASS__, 's_parseValue'],
            'parseLiteral' => [__CLASS__, 's_parseLiteral'],
        ]);
    }

    public static function s_serialize(DateTime $value)
    {
        return $value->format(DateTime::ISO8601);
    }

    public static function s_parseValue(string $value)
    {
        return static::do_parse($value);
    }

    public static function s_parseLiteral($valueNode)
    {
        if (!$valueNode instanceof StringValueNode) {
            throw new Error('Query error: Can only parse strings got: ' . $valueNode->kind, [$valueNode]);
        }
        return static::do_parse($valueNode->value);
    }

    private static function do_parse(string $value)
    {
        try {
            return new DateTime($value);
        } catch (Exception $e) {
            throw new Error("Cannot represent value as timestamp: " . Utils::printSafe($value)
                . "; " . $e->getMessage());
        }
    }
}
