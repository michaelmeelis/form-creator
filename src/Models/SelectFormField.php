<?php

namespace BeFriends\Admin\FormCreator\Models;


class SelectFormField extends FormField
{
    public $selection;

    public function __construct($name, $propertyType, $value, array $selection = [])
    {
        $this->name = $name;
        $this->propertyType = $propertyType;
        $this->value = $value;
        $this->selection = $selection;
    }

    public function setSelection(array $selection)
    {
        $this->selection = $selection;
    }
} 