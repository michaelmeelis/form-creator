<?php

namespace michaelmeelis\FormCreator\Models;

use michaelmeelis\FormCreator\FormModels\FormModelInterface;

class FormField
{
    public $name;
    public $propertyType;
    public $value;
    public $displayName;

    /**
     * @var FormModelInterface
     */
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

    /**
     * @param FormModelInterface $model
     */
    public function setModel(FormModelInterface $model)
    {
        $this->model = $model;
    }
}