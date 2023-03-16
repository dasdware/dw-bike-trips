<?php

namespace DW\BikeTrips\API\Utils;

use Brick\DateTime\LocalDate;
use Brick\DateTime\LocalTime;
use GraphQL\Error\Error;

class Timestamp
{

    private LocalDate $date;
    private ?LocalTime $time;

    function __construct(LocalDate $date, LocalTime $time = null)
    {
        $this->date = $date;
        $this->time = $time;
    }

    function date()
    {
        return $this->date;
    }

    function time()
    {
        return $this->time;
    }

    function format()
    {
        $result = $this->date->__toString();
        if ($this->time !== null) {
            $result .= ' ' . $this->time->__toString();
        } else {
            $result .= ' 00:00:00';
        }
        return $result;
    }

    function __toString()
    {
        $result = $this->date->__toString();
        if ($this->time !== null) {
            $result .= 'T' . $this->time->__toString();
        }
        return $result;
    }

    static function fromString(String $value)
    {
        if (preg_match('/^(\d{4}-\d{2}-\d{2})(?:T(\d{2}:\d{2}:\d{2}))?$/', $value, $matches)) {
            $date = LocalDate::parse($matches[1]);
            $time = !empty($matches[2]) ? LocalTime::parse($matches[2]) : null;
            return new Timestamp($date, $time);
        }

        throw new Error('Invalid timestamp string: ' . $value);
    }

    static function fromDatabase(String $timestamp, bool $has_time)
    {
        if (preg_match('/^(\d{4}-\d{2}-\d{2}) (\d{2}:\d{2}:\d{2})$/', $timestamp, $matches)) {
            $date = LocalDate::parse($matches[1]);
            $time = $has_time ? LocalTime::parse($matches[2]) : null;
            return new Timestamp($date, $time);
        }

        throw new Error('Invalid database timestamp string: ' . $timestamp);
    }

    static function fromStrings(String $date, String $time = null)
    {
        $localDate = LocalDate::parse($date);
        $localTime = (!empty($time)) ? LocalTime::parse($time) : null;
        return new Timestamp($localDate, $localTime);
    }
}
