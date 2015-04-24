<?php

namespace michaelmeelis\FormCreator\Factory\FormField;

use michaelmeelis\FormCreator\Factory\FormField\Options\BaseOption;
use michaelmeelis\FormCreator\Helpers\PropertyHelper;
use michaelmeelis\FormCreator\Models\FormField;

class FormFieldFactory
{
    const DEFAULT_FORM_FIELD_MODEL = 'michaelmeelis\FormCreator\Models\FormField';
    /**
     * @var BaseOption[]
     */
    private $options;

    private $settings;

    private $fieldTypeToModel = [
        'select' => 'michaelmeelis\FormCreator\Models\SelectFormField',
        'checkbox' => 'michaelmeelis\FormCreator\Models\SelectFormField',
        'Carbon' => 'michaelmeelis\FormCreator\Models\FormField',
    ];
    
    /**
     * @var FormField
     */
    private $formField;
    private $formFieldValue;

    public function __construct(array $settings = [])
    {
        $this->settings = $settings;
    }

    /**
     * @param string $formFieldName
     * @param mixed $formFieldValue
     * @param BaseOption[] $options
     * @return FormField
     */
    public function createFormField($formFieldName, $formFieldValue, array $options = [])
    {
        $this->options = $options;
        $this->formFieldValue = $formFieldValue;
        $this->formField = $this->initFormField($formFieldName, $formFieldValue);

        $this->options = $this->initOptions();
        $this->applyOptions();

        return $this->formField;
    }

    private function initFormField($formFieldName, $formFieldValue)
    {
        $propertyType = PropertyHelper::assessType($formFieldValue);
        $fieldClass = $this->getFieldClassName($propertyType);

        return new $fieldClass($formFieldName, $propertyType, $formFieldValue);
    }

    private function initOptions()
    {
        $optionFactory = new OptionFactory();
        $options = $this->options + $optionFactory->createFormFieldOptions($this->formField);

        return $options;
    }

    /**
     * @param $type
     * @return string
     * @todo laravel specific function class_basename
     */
    private function getFieldClassName($type)
    {
        $className = substr($this->formFieldValue, strrpos($this->formFieldValue, '\\')+1);
        if ($this->hasModelOption()) {
            return 'michaelmeelis\FormCreator\Models\SelectFormField';
        }
        if (isset($this->fieldTypeToModel[$type]) && !isset($this->fieldTypeToModel[$className])) {
            return $this->fieldTypeToModel[$type];
        } elseif (isset($this->fieldTypeToModel[$className])) {
            return $this->fieldTypeToModel[$className];
        }

        return self::DEFAULT_FORM_FIELD_MODEL;
    }

    public function applyOptions()
    {
        foreach ($this->options as $option) {
            $this->formField = $option->applyOption($this->formField);
        }
    }

    private function hasModelOption()
    {
        foreach ($this->options as $option) {
            $baseNameOption = substr($option, strrpos($option, '\\')+1);
            if ($baseNameOption == 'ModelOption') {
                return true;
            }
        }

        return false;
    }
}