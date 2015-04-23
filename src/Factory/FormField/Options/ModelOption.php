<?php

namespace BeFriends\Admin\FormCreator\Factory\FormField\Options;

use BeFriends\Admin\FormCreator\FormCreator;
use BeFriends\Admin\FormCreator\Models\FormField;

class ModelOption extends BaseOption
{
    private $formFieldModelClass;

    /**
     * @var FormField
     */
    private $formField;

    public function __construct(array $settings, $formFieldModelClass)
    {
        $this->formFieldModelClass = $formFieldModelClass;

        parent::__construct($settings);
    }


    /**
     * @param FormField $formField
     * @return FormField
     */
    public function applyOption(FormField $formField)
    {
        if ($this->checkIfModelPresent($formField) && $this->isValidClass($this->formFieldModelClass)) {
            return $formField;
        }

        $this->formField = $formField;

        return $this->buildFormField();
    }

    private function checkIfModelPresent(FormField $formField)
    {
        if (is_object($formField->model)) {
            return true;
        }

        return false;
    }

    private function isValidClass($formFieldModelClass)
    {
        return class_exists($formFieldModelClass);
    }

    private function buildFormField()
    {
        $this->formField->model = $this->createFormFieldModel();
        $this->formField->propertyType = FormCreator::MULTIPLE_VALUES_SINGLE_SELECTOR;
        $this->formField->value = $this->translateDataModelToValue();

        return $this->formField;
    }

    /**
     * @todo Too specific filter out the laravel model
     *
     * @return \Eloquent
     */
    private function createFormFieldModel()
    {
        $class = $this->formFieldModelClass;
        return $class::findOrNew($this->formField->value);
    }


    private function translateDataModelToValue()
    {
        if (!$this->checkModelToValueSetting()) {
            throw new \DomainException('');
        }

        $fieldName = $this->settings['options']['ModelOption'][$this->formField->name];

        return $this->formField->model->{$fieldName};

    }

    private function checkModelToValueSetting()
    {
        if (!isset($this->settings['options']['ModelOption'])) {
            throw new \DomainException(
                'No settings found for the ModelOption class.
                Please define in settings [options][ModelOption]
                For ' .$this->formField->name
            );
        }

        $modelOptionSettings = $this->settings['options']['ModelOption'];

        if (!isset($modelOptionSettings[$this->formField->name])) {
            throw new \DomainException(
                'No settings found for ' . $this->formField->name . '
                Please define in settings [options][ModelOption]'
            );
        }

        return true;
    }
}
