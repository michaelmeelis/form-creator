<?php

namespace michaelmeelis\FormCreator;


use michaelmeelis\FormCreator\FormModels\BaseFormModel;
use michaelmeelis\FormCreator\FormViews\ViewAdapter;

class FormDecorator {

    public function __construct(BaseFormModel $formModel, ViewAdapter $viewAdapter = null)
    {
    }

} 