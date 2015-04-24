<?php

namespace michaelmeelis\FormCreator\Factory\FormField\Options;

use michaelmeelis\FormCreator\Models\FormField;

class NullOption extends BaseOption
{
    private $invalidOptionName;

    public function __construct($invalidOptionName)
    {
        $this->invalidOptionName = $invalidOptionName;
    }

    /**
     * @param FormField $formField
     * @return FormField
     */
    public function applyOption(FormField $formField)
    {
        $formField->value = $formField->value . 'The option ' .$this->invalidOptionName .' does not exists';

        return $formField;
    }
}