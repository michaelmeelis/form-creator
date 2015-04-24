<?php

namespace michaelmeelis\FormCreator\Factory\FormFieldCollection\Adapters;


use michaelmeelis\FormCreator\Models\FormField;

class NullAdapter extends BaseAdapter
{

    public function adapt($dataModel)
    {
        $emptyFormField = new FormField('invalid', 'text', 'Null adapter used');
        return  [$emptyFormField];
    }
}