<?php

namespace BeFriends\Admin\FormCreator\Factory\FormFieldCollection\Adapters;

use BeFriends\Admin\FormCreator\Factory\FormField\FormFieldFactory;

abstract class BaseAdapter
{
    const DEFAULT_FIELD_CLASS = 'BeFriends\Admin\FormCreator\Models\FormField';

    /**
     * @var FormFieldFactory
     */
    protected $formFieldFactory;
    protected $settings = [];
    protected $skipSettingOptions = [
        'ModelOption'
    ];
    protected $model;

    /**
     * @param array $settings
     */
    public function __construct(array $settings = [])
    {
        $this->settings = $settings;
        $this->formFieldFactory = new FormFieldFactory();
    }

    abstract public function adapt($dataModel);

    /**
     * @param string $formFieldName
     * @param string $formFieldValue
     * @param array $options
     * @return array
     */
    protected function createFormField($formFieldName, $formFieldValue, array $options = [])
    {
        return $this->formFieldFactory->createFormField($formFieldName, $formFieldValue, $options);
    }

    protected function createOptions($className = '')
    {
        $options = array_merge($this->createDefaultOptions($className), $this->createSettingsOptions());

        return $options;
    }

    /**
     * Use this function to add options to the adapter
     * @param string $className
     * @return array
     */
    protected function createDefaultOptions($className = '')
    {
        return [];
    }

    /**
     * @todo Somehow the order of the settings are fixed and can't be changed
     * @return array
     * @throws \Exception
     */
    protected function createSettingsOptions()
    {
        $options = [];
        if (isset($this->settings['options']) && !empty($this->settings['options'])) {
            foreach ($this->settings['options'] as $optionClassName => $optionSettings) {
                foreach ($optionSettings as $fieldName => $value) {
                    $options[] = $this->createOption($optionClassName);
                }
            }
        }
        return array_filter($options);
    }

    private function createOption($optionClassName)
    {
        $fullClassName = "BeFriends\\Admin\\FormCreator\\Factory\\FormField\\Options\\" .$optionClassName;
        if (!class_exists($fullClassName)) {
            throw new \Exception('Not a valid options ' .$fullClassName);
        } elseif (!in_array($optionClassName, $this->skipSettingOptions)) {
            return new $fullClassName($this->settings);
        }

        return null;
    }
}