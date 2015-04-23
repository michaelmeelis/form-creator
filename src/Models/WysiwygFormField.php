<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 03/10/14
 * Time: 20:57
 */

namespace BeFriends\Admin\FormCreator\Models;


class WysiwygField extends FormField
{
    public $rows = 30;

    public function setRows($amountRows)
    {
        $this->rows = $amountRows;
    }
} 