<?php

namespace BeFriends\Admin\FormCreator\Models;

class FormField
{
    public $name;
    public $propertyType;
    public $value;
    public $displayName;

    public $model;
    public $relatedTable;

    public $toolTip = '';

    public function __construct($name, $propertyType, $value)
    {
        $this->name = $name;
        $this->propertyType = $propertyType;
        $this->value = $value;
        $this->displayName = $name;
    }

    public function setDisplayName($value)
    {
        $this->displayName = $value;
    }

    public function setToolTip($value)
    {
        $this->toolTip = $value;
    }

    public function setModel($model)
    {
        $this->model = $model;
    }
}