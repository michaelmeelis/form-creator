<?php

namespace michaelmeelis\FormCreator\Models;


class WysiwygField extends FormField
{
    public $rows = 30;

    public function setRows($amountRows)
    {
        $this->rows = $amountRows;
    }
} 