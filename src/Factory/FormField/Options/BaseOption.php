<?php

namespace michaelmeelis\FormCreator\Factory\FormField\Options;


use michaelmeelis\FormCreator\Helpers\SettingsHelper;
use michaelmeelis\FormCreator\Models\FormField;

/**
 * Class BaseOption
 * @todo replace the settings helper
 * @package michaelmeelis\FormCreator\Factory\FormField\Options
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