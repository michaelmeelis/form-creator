<?php

namespace michaelmeelis\FormCreator\Factory\FormField\Options;


use michaelmeelis\FormCreator\Models\FormField;

class RemoveOption extends BaseOption
{

    public function applyOption(FormField $formField)
    {
        if (isset($this->localSettings[$formField->name])) {
            if ($formField->value == $this->localSettings[$formField->name]
                || $this->localSettings[$formField->name] == '*') {
                return null;
            }
        }

        return $formField;
    }
}
