<?php
namespace michaelmeelis\FormCreator\Helpers;

use michaelmeelis\FormCreator\FormCreator;
use Carbon\Carbon;

class PropertyHelper
{

    static private $minLengthTextarea = 125;
    static private $translateObject = [
        'Carbon\Carbon'
    ];

    /**
     * @todo change gettype to own function to accept 1 to n
     * @todo array in switch might be bug
     * @param $assesValue
     * @return string
     */
    public static function assessType($assesValue)
    {
        $type = gettype($assesValue);
        switch ($type) {
            case 'integer':
                return FormCreator::SINGLE_VALUE_STRING;
            case 'string':
                return self::determineMetaStringType($assesValue);
            case 'array':
                return FormCreator::MULTIPLE_VALUES_SINGLE_SELECTOR;
            case 'boolean':
                return FormCreator::SINGLE_VALUE_BOOLEAN;
            case 'object':
                return self::determineObjectType($assesValue);
            default:
                return FormCreator::SINGLE_VALUE_STRING;
        }
    }

    public static function determineMetaStringType($value)
    {
        if (strlen($value) > self::$minLengthTextarea) {
            return FormCreator::SINGLE_VALUE_TEXT;
        }

        if (strtotime($value) !== false) {
            return self::determineDateTimeString($value);
        }

        return FormCreator::SINGLE_VALUE_STRING;
    }

    public static function determineObjectType($value)
    {
        $className = get_class($value);
        if (in_array($className, self::$translateObject)) {
            return FormCreator::SINGLE_VALUE_DATETIME;
        }

        return FormCreator::MULTIPLE_VALUES_SINGLE_SELECTOR;
    }

    public static function determineDateTimeString($value)
    {
        $typeHinting = new Carbon($value);
        if (self::checkIfTimeOny($typeHinting)) {
            return FormCreator::SINGLE_VALUE_TIME;
        } else {
            if (self::checkIfDateOnly($typeHinting)) {
                return FormCreator::SINGLE_VALUE_DATE;
            }
            return FormCreator::SINGLE_VALUE_DATETIME;
        }
    }

    private static function checkIfTimeOny(\DateTime $dateTime)
    {
        if (empty($dateTime->year) && empty($dateTime->month) && empty($dateTime->day)) {
            if (!empty($dateTime->hour) || !empty($dateTime->minute) || !empty($dateTime->second)) {
                return true;
            }
        }

        return false;
    }

    private static function checkIfDateOnly(\DateTime $dateTime)
    {
        if (empty($dateTime->hour) && empty($dateTime->minute) && empty($dateTime->second)) {
            return true;
        }

        return false;

    }
}