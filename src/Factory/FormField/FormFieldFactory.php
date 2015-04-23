<?php

namespace BeFriends\Admin\FormCreator\Factory\FormField;

use BeFriends\Admin\FormCreator\Factory\Helpers\OptionHandler;
use BeFriends\Admin\FormCreator\Factory\FormField\Options\BaseOption;
use BeFriends\Admin\FormCreator\Helpers\PropertyHelper;
use BeFriends\Admin\FormCreator\Models\FormField;

class FormFieldFactory
{
    const DEFAULT_FORM_FIELD_MODEL = 'BeFriends\Admin\FormCreator\Models\FormField';
    /**
     * @var BaseOption[]
     */
    private $options;

    private $settings;

    private $fieldTypeToModel = [
        'select' => 'BeFriends\Admin\FormCreator\Models\SelectFormField',
        'checkbox' => 'BeFriends\Admin\FormCreator\Models\SelectFormField',
        'Carbon' => 'BeFriends\Admin\FormCreator\Models\FormField',
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

    private function getFieldClassName($type)
    {
        $className = class_basename($this->formFieldValue);
        if ($this->hasModelOption()) {
            return 'BeFriends\Admin\FormCreator\Models\SelectFormField';
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
            if (class_basename($option) == 'ModelOption') {
                return true;
            }
        }

        return false;
    }
}