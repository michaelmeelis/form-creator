<?php

namespace BeFriends\Admin\FormCreator;

use BeFriends\Admin\Adapters\AdapterInterface;
use BeFriends\Admin\FormCreator\FormModels\BaseFormModel;
use BeFriends\Admin\FormCreator\FormViews\ViewAdapter;

class FormCreator
{
    const SINGLE_VALUE_DATE = 'date';
    const SINGLE_VALUE_TIME = 'time';
    const SINGLE_VALUE_DATETIME = 'datetime';
    const SINGLE_VALUE_BOOLEAN = 'radio';
    const SINGLE_VALUE_STRING = 'text';
    const SINGLE_VALUE_TEXT = 'textarea';
    const SINGLE_VALUE_WYSIWYG = 'wysiwyg';
    const MULTIPLE_VALUES_SINGLE_SELECTOR = 'select';
    const MULTIPLE_VALUES_MULTIPLE_SELECTOR = 'checkbox';

    const TRANSLATE_STRING = 'string';
    const TRANSLATE_MULTIPLE = 'array';

    protected $formModel;
    protected $header;
    protected $footer;

    /**
     * @param BaseFormModel $formModel
     * @param ViewAdapter $viewAdapter
     */
    public function __construct(BaseFormModel $formModel, ViewAdapter $viewAdapter = null)
    {
        $this->formModel = $formModel;
        $this->viewAdapter = $viewAdapter;
        $this->formDecorator = new FormDecorator($formModel, $viewAdapter);

        return $this;
    }

    /**
     * @param string $header
     */
    public function setHeader($header)
    {
        $this->header = $header;
    }

    /**
     * @param string $footer
     */
    public function setFooter($footer)
    {
        $this->footer = $footer;
    }

    public function build()
    {
        return $this->viewAdapter->build();
    }

    public function getModelName()
    {
        return $this->formModel->getLinkedModelName();
    }

}
