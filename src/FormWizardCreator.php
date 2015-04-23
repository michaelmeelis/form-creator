<?php

namespace BeFriends\Admin\FormCreator;


use BeFriends\Admin\FormCreator\Collections\FormCreatorCollection;
use BeFriends\Admin\FormCreator\FormModels\BaseFormModel;
use BeFriends\Admin\FormCreator\FormViews\ViewAdapter;
use michaelmeelis\DocBlockModelParser\Factory\PropertyFactory;

class FormWizardCreator
{
    private $coreFormModel;
    private $viewAdapter;
    /**
     * @var BaseFormModel[]
     */
    private $wizardFormModels;
    private $propertyFactory;
    /**
     * @var FormCreatorCollection
     */
    private $forms;

    public function __construct(BaseFormModel $coreFormModel, ViewAdapter $viewAdapter, $wizardFormModels = [])
    {
        $this->coreFormModel = $coreFormModel;
        $this->viewAdapter = $viewAdapter;
        $this->wizardFormModels = $wizardFormModels;
        $this->propertyFactory = new PropertyFactory();
        $this->forms = new FormCreatorCollection();

    }

    public function build()
    {
        $this->buildCoreForm();
        $this->buildWizardForms();
    }

    public function buildHtml()
    {
        $html = '';
        foreach ($this->forms as $form) {
            $html .= $form->build();
        }

        return $html;
    }

    public function getForms()
    {
        return $this->forms;
    }

    public function applyOrder($order)
    {
        $this->forms->applyOrder($order);
    }

    private function buildCoreForm()
    {
        $this->forms[] = new FormCreator($this->coreFormModel, $this->viewAdapter);
    }

    private function buildWizardForms()
    {
        $this->buildSingleForm();
        $this->buildMultipleForm();
    }

    private function buildSingleForm()
    {
        $singleProperties = $this->propertyFactory->buildSingleProperties($this->coreFormModel->getDataModel());
        foreach ($singleProperties as $property) {
            $formModel = $this->buildFormModel($property->modelClassName, $property->table);
            $formWizardCreator = $this->buildFormWizardCreator($formModel);
            $this->forms->merge($formWizardCreator->getForms());
        }
    }

    private function buildMultipleForm()
    {
        $multipleProperties = $this->propertyFactory->buildMultipleProperties($this->coreFormModel->getDataModel());
        foreach ($multipleProperties as $property) {
            $formModel = $this->getWizardFormModel($property->modelClassName);
            $dataCollection = $this->coreFormModel->getDataRelation($property->table);
            foreach ($dataCollection as $dataModel) {
                $multipleFormModel = clone $formModel;
                $multipleFormModel->setDataModel($dataModel);
                $multipleFormModel->build();
                $formWizardCreator = $this->buildFormWizardCreator($multipleFormModel);
                $this->forms->merge($formWizardCreator->getForms());
            }
        }
    }

    private function getWizardFormModel($modelName)
    {
        foreach ($this->wizardFormModels as $wizardFormModel) {
            if ($modelName == $wizardFormModel->getLinkedModelName()) {
                return $wizardFormModel;
            }
        }

        throw new \Exception('Could not find a wizard form model for: ' . $modelName);
    }

    /**
     * @param string $modelName
     * @param string $table
     * @return BaseFormModel
     */
    private function buildFormModel($modelName, $table)
    {
        $formModel = $this->getWizardFormModel($modelName);
        $dataModel = $this->coreFormModel->getDataRelation($table);
        $formModel->setDataModel($dataModel);
        $formModel->build();

        return $formModel;
    }

    /**
     * @param BaseFormModel $formModel
     * @return FormWizardCreator
     */
    private function buildFormWizardCreator(BaseFormModel $formModel)
    {
        $viewAdapter = clone $this->viewAdapter;
        $viewAdapter->setFormModel($formModel);
        $formWizardCreator = new FormWizardCreator($formModel, $viewAdapter, $this->wizardFormModels);
        $formWizardCreator->build();

        return $formWizardCreator;
    }
}
