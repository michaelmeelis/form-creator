<?php

namespace BeFriends\Admin\FormCreator\Factory\FormFieldCollection\Adapters;


use BeFriends\Admin\FormCreator\Models\FormField;

class NullAdapter extends BaseAdapter
{

    public function adapt($dataModel)
    {
        $emptyFormField = new FormField('invalid', 'text', 'Null adapter used');
        return  [$emptyFormField];
    }
}