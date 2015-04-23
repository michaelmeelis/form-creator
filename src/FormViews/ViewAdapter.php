<?php

namespace BeFriends\Admin\FormCreator\FormViews;

use BeFriends\Admin\FormCreator\FormModels\BaseFormModel;
use BeFriends\Admin\FormCreator\Models\FormField;

abstract class ViewAdapter
{
    protected $viewLocation = '../Views/';
    protected $viewStructureName = 'formcreator-container';

    protected $data =
        [
            'header' => '',
            'content' => '',
            'footer' => '',
        ];

    /**
     * @var BaseFormModel
     */
    protected $formModel;
    protected $viewPostFix = 'input-';

    public function __construct(BaseFormModel $formModel)
    {
        $this->formModel = $formModel;
    }

    protected function buildTemplateVariables()
    {
        $data['header'] = $this->formModel->getHeader();
        $data['content'] = $this->buildContent();
        $data['footer'] = $this->formModel->getFooter();

        return $data;
    }

    public function setFormModel(BaseFormModel $formModel)
    {
        $this->formModel = $formModel;
    }

    /**
     * @param FormField $field
     * @return string
     */
    protected function buildViewNameFromField(FormField $field)
    {
        return $this->viewLocation . $this->viewPostFix . $field->propertyType;
    }

    protected function getStructure()
    {
        $file = $this->viewLocation .$this->viewStructureName .'.php';
        return file_get_contents($file);
    }

    /**
     * @return string
     */
    abstract public function build();
    abstract protected function buildContent();
}