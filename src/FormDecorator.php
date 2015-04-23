<?php

namespace BeFriends\Admin\FormCreator;


use BeFriends\Admin\FormCreator\FormModels\BaseFormModel;
use BeFriends\Admin\FormCreator\FormViews\ViewAdapter;

class FormDecorator {

    public function __construct(BaseFormModel $formModel, ViewAdapter $viewAdapter = null)
    {
    }

} 