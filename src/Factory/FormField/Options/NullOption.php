<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 07/11/14
 * Time: 22:37
 */

namespace BeFriends\Admin\FormCreator\Factory\FormField\Options;

use BeFriends\Admin\FormCreator\Models\FormField;

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