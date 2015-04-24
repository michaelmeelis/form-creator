<?php

namespace michaelmeelis\FormCreator\Factory\FormField\Options;


use michaelmeelis\FormCreator\Models\FormField;

class RelatedTableOption extends BaseOption
{
    /**
     * @param FormField $formField
     * @return FormField
     */
    public function applyOption(FormField $formField)
    {
        $formField->relatedTable = $formField->model->getTable();
        return $formField;
    }
}