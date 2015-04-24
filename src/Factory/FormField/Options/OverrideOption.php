<?php

namespace michaelmeelis\FormCreator\Factory\FormField\Options;

use michaelmeelis\FormCreator\Models\FormField;

abstract class OverrideOption extends BaseOption
{
    protected $value;

    /**
     * @todo larvel specific function (class_basename) need to replace
     * @return string
     */
    protected function getPropertyFromClass()
    {
        $className = class_basename($this);
        $property = substr($className, 0, -6);

        return lcfirst($property);
    }

    public function applyOption(FormField $formField)
    {
        return $this->override($formField);
    }

    public function override($formField)
    {
        $property = $this->getPropertyFromClass();
        $formField = $this->applyProperty($formField, $property);

        return $formField;
    }

    private function applyProperty(FormField $formField, $property)
    {
        if (!property_exists($formField, $property)) {
            throw new \UnexpectedValueException('Attribute ' .$property .' does not exist in: ' .get_class($formField));
        }

        $formField->{$property} = $this->getOverrideValue($formField, $property);

        return $formField;
    }

    private function getOverrideValue(FormField $formField, $property)
    {
        if (isset($this->localSettings[$formField->name]) && !empty($this->localSettings[$formField->name])) {
            return $this->localSettings[$formField->name];
        }

        return $formField->{$property};
    }

} 