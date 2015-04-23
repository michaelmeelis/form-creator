<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 08/11/14
 * Time: 12:41
 */

namespace BeFriends\Admin\FormCreator\Factory\FormField\Options;


use BeFriends\Admin\FormCreator\Models\FormField;

class RelatedTableOption extends BaseOption
{
    /**
     * @todo Too laravel specific change!
     * @param FormField $formField
     * @return FormField
     */
    public function applyOption(FormField $formField)
    {
        $formField->relatedTable = $formField->model->getTable();
        return $formField;
    }
}