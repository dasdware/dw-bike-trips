<?php

namespace DW\BikeTrips\API\Schema;

use DW\BikeTrips\API\Schema\Type\AccumulatedTripType;
use DW\BikeTrips\API\Schema\Type\Enum\RangeNameType;
use DW\BikeTrips\API\Schema\Type\Enum\SortDirectionType;
use DW\BikeTrips\API\Schema\Type\Enum\TripFieldType;
use DW\BikeTrips\API\Schema\Type\LimitType;
use DW\BikeTrips\API\Schema\Type\LoggedInType;
use DW\BikeTrips\API\Schema\Type\MeType;
use DW\BikeTrips\API\Schema\Type\OrderType;
use DW\BikeTrips\API\Schema\Type\RangeType;
use DW\BikeTrips\API\Schema\Type\Scalar\TimestampType;
use DW\BikeTrips\API\Schema\Type\TripType;
use Exception;
use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\Type;

class Types
{
    public static function me(): callable
    {
        return static::get(MeType::class);
    }

    public static function loggedIn(): callable
    {
        return static::get(LoggedInType::class);
    }

    public static function timestamp(): callable
    {
        return static::get(TimestampType::class);
    }

    public static function rangeName(): callable
    {
        return static::get(RangeNameType::class);
    }

    public static function range(): callable
    {
        return static::get(RangeType::class);
    }

    public static function trip(): callable
    {
        return static::get(TripType::class);
    }

    public static function tripField(): callable
    {
        return static::get(TripFieldType::class);
    }

    public static function sortDirection(): callable
    {
        return static::get(SortDirectionType::class);
    }

    public static function order(): callable
    {
        return static::get(OrderType::class);
    }

    public static function limit(): callable
    {
        return static::get(LimitType::class);
    }


    public static function accumulatedTrip(): callable
    {
        return static::get(AccumulatedTripType::class);
    }

    public static function boolean()
    {
        return Type::boolean();
    }

    /**
     * @return \GraphQL\Type\Definition\FloatType
     */
    public static function float()
    {
        return Type::float();
    }

    /**
     * @return \GraphQL\Type\Definition\IDType
     */
    public static function id()
    {
        return Type::id();
    }

    /**
     * @return \GraphQL\Type\Definition\IntType
     */
    public static function int()
    {
        return Type::int();
    }

    /**
     * @return \GraphQL\Type\Definition\StringType
     */
    public static function string()
    {
        return Type::string();
    }

    /**
     * @param Type $type
     * @return ListOfType
     */
    public static function listOf($type)
    {
        return new ListOfType($type);
    }

    /**
     * @param Type $type
     * @return NonNull
     */
    public static function nonNull($type)
    {
        return Type::nonNull($type);
    }

    private static $types = [];
    const LAZY_LOAD_GRAPHQL_TYPES = true;

    public static function get($classname)
    {
        return static::LAZY_LOAD_GRAPHQL_TYPES ? function () use ($classname) {
            return static::byClassName($classname);
        } : static::byClassName($classname);
    }

    protected static function byClassName($classname)
    {
        $parts = explode("\\", $classname);
        $cacheName = strtolower(preg_replace('~Type$~', '', $parts[count($parts) - 1]));
        $type = null;

        if (!isset(self::$types[$cacheName])) {
            if (class_exists($classname)) {
                $type = new $classname();
            }

            self::$types[$cacheName] = $type;
        }

        $type = self::$types[$cacheName];

        if (!$type) {
            throw new Exception("Unknown graphql type: " . $classname);
        }
        return $type;
    }
}
