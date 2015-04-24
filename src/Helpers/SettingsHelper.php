<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 23/11/14
 * Time: 19:24
 */

namespace michaelmeelis\FormCreator\Helpers;


class SettingsHelper
{

    public static function getSettingsKey($object)
    {
        return class_basename($object);
    }

    public static function getLocalSettings($object, $settings)
    {
        $settingKey = self::getSettingsKey($object);
        foreach ($settings as $base => $baseValues) {
            if (isset($baseValues[$settingKey]) && !empty($baseValues[$settingKey])) {
                return $baseValues[$settingKey];
            }
        }
    }
} 