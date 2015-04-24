<?php

namespace michaelmeelis\FormCreator\Factory\FormField;

use michaelmeelis\FormCreator\Factory\FormField\Options\NullOption;
use michaelmeelis\FormCreator\Factory\FormField\Options\BaseOption;
use michaelmeelis\FormCreator\Models\FormField;

class OptionFactory
{
    const OPTIONS_NAMESPACE = "BeFriends\\Admin\\FormCreator\\Factory\\FormField\\Options\\";

    const FORM_FIELD_SETTINGS_KEY_NAME = "formFieldOptions";

    private $defaultOptions = [
        'selection' => [
            'SelectionOption'
        ],
    ];

    private $settings;

    /**
     * @param FormField $formField
     * @param array $settings
     * @param BaseOption[] $options
     * @return BaseOption[]
     */
    public function createFormFieldOptions(FormField $formField, $settings = [], $options = [])
    {
        $this->settings = $settings;

        $options = $options + $this->buildSettingOptions($settings);
        $options = $options + $this->buildDefaultOptions($formField);

        return $options;
    }


    private function buildSettingOptions(array $settings)
    {
        $options = [];

        $settingOptions = $this->getOptionsFromSettings($settings);
        foreach ($settingOptions as $optionName) {
            $options[] = $this->createOption(self::OPTIONS_NAMESPACE . $optionName);
        }
        return $options;
    }

    private function buildDefaultOptions(FormField $formField)
    {
        $options = [];

        $formFieldType = $this->buildFormFieldType($formField);
        $defaultOptions = $this->getOptionsFromDefault($formFieldType);
        foreach ($defaultOptions as $optionName) {
            $options[] = $this->createOption(self::OPTIONS_NAMESPACE . $optionName);
        }

        return $options;
    }

    private function createOption($optionClassName)
    {
        if (class_exists($optionClassName)) {
            return new $optionClassName($this->settings);
        }

        \Log::alert('Option not found: ' . $optionClassName);

        return new NullOption($optionClassName);
    }

    /**
     * @param array $settings
     * @return array
     */
    private function getOptionsFromSettings(array $settings)
    {
        if (isset($settings[self::FORM_FIELD_SETTINGS_KEY_NAME]) &&
            is_array($settings[self::FORM_FIELD_SETTINGS_KEY_NAME])
        ) {
            return $settings[self::FORM_FIELD_SETTINGS_KEY_NAME];
        }

        return [];
    }

    private function buildFormFieldType(FormField $formField)
    {
        if (is_object($formField->value)) {
            return 'model';
        }

        if (is_array($formField->value)) {
            return 'selection';
        }

        return 'text';
    }

    private function getOptionsFromDefault($defaultKey)
    {
        if (!isset($this->defaultOptions[$defaultKey])) {
            return [];
        }

        return $this->defaultOptions[$defaultKey];
    }
}
