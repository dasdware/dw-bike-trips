<?php

namespace DW\BikeTrips\API\Utils;

use DateTime;
use DW\BikeTrips\API\Schema\Type\Enum\RangeNameType;

class DateTimeRange
{
    public $from;
    public $to;

    public function __construct(DateTime $from, DateTime $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function format()
    {
        return $this->formatFrom() . ' - ' . $this->formatTo();
    }

    public function formatFrom()
    {
        return $this->from->format(DateTime::ISO8601);
    }

    public function formatTo()
    {
        return $this->to->format(DateTime::ISO8601);
    }

    static function today()
    {
        $from = new DateTime(date("Y-m-d"));

        $to = clone $from;
        $to->modify("+1 day -1 second");

        return new DateTimeRange($from, $to);
    }

    static function thisWeek()
    {
        $from = new DateTime(date("Y-m-d", strtotime('monday this week')));

        $to = clone $from;
        $to->modify("+1 week -1 second");

        return new DateTimeRange($from, $to);
    }

    static function thisMonth()
    {
        $from = new DateTime(date("Y-m-01"));

        $to = clone $from;
        $to->modify("+1 month -1 second");

        return new DateTimeRange($from, $to);
    }

    static function thisYear()
    {
        $from = new DateTime(date("Y-01-01"));

        $to = clone $from;
        $to->modify("+1 year -1 second");

        return new DateTimeRange($from, $to);
    }

    static function yesterday()
    {
        $from = new DateTime(date("Y-m-d"));
        $from->modify("-1 day");

        $to = clone $from;
        $to->modify("+1 day -1 second");

        return new DateTimeRange($from, $to);
    }


    static function lastWeek()
    {
        $from = new DateTime(date("Y-m-d", strtotime('monday this week')));
        $from->modify("-1 week");

        $to = clone $from;
        $to->modify("+1 week -1 second");

        return new DateTimeRange($from, $to);
    }

    static function lastMonth()
    {
        $from = new DateTime(date("Y-m-01"));
        $from->modify("-1 month");

        $to = clone $from;
        $to->modify("+1 month -1 second");

        return new DateTimeRange($from, $to);
    }

    static function lastYear()
    {
        $from = new DateTime(date("Y-01-01"));
        $from->modify("-1 year");

        $to = clone $from;
        $to->modify("+1 year -1 second");

        return new DateTimeRange($from, $to);
    }

    static function byName(string $name)
    {
        switch ($name) {
            case RangeNameType::NAME_TODAY:
                return static::today();
            case RangeNameType::NAME_THIS_WEEK:
                return static::thisWeek();
            case RangeNameType::NAME_THIS_MONTH:
                return static::thisMonth();
            case RangeNameType::NAME_THIS_YEAR:
                return static::thisYear();
            case RangeNameType::NAME_YESTERDAY:
                return static::yesterday();
            case RangeNameType::NAME_LAST_WEEK:
                return static::lastWeek();
            case RangeNameType::NAME_LAST_MONTH:
                return static::lastMonth();
            case RangeNameType::NAME_LAST_YEAR:
                return static::lastYear();
        }
        return static::today();
    }
}
