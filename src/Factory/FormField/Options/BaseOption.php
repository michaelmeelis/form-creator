<?php

namespace BeFriends\Admin\FormCreator\Factory\FormField\Options;


use BeFriends\Admin\FormCreator\Helpers\SettingsHelper;
use BeFriends\Admin\FormCreator\Models\FormField;

/**
 * Class BaseOption
 * @todo replace the settings helper
 * @package BeFriends\Admin\FormCreator\Factory\FormField\Options
 */
abstract class BaseOption
{
    protected $settings = [];
    protected $localSettings = [];

    /**
     * @param FormField $formField
     * @return FormField
     */
    abstract public function applyOption(FormField $formField);

    public function __construct($settings)
    {
        $this->settings = $settings;
        $this->localSettings = SettingsHelper::getLocalSettings($this, $settings);
    }
} 