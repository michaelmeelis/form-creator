<?php

namespace BeFriends\Admin\FormCreator\Factory\FormFieldCollection;

use BeFriends\Admin\FormCreator\Collections\FormFieldCollection;
use BeFriends\Admin\FormCreator\Factory\FormField\Options\BaseOption;
use BeFriends\Admin\FormCreator\Factory\FormFieldCollection\Adapters\BaseAdapter;

class FieldCollectionFactory
{
    const STANDARD_ID_FIELD = 'id';

    private $dataModel;
    private $fields = [];
    private $subtract;
    /**
     * @var BaseOption[]
     */
    private $userOptions = [];

    /**
     * @var BaseAdapter[]
     */
    private $adapters;

    /**
     * @param $dataModel The model where the form is going to be based on
     * @param $settings
     * @param BaseAdapter[] $adapters
     */
    public function __construct($dataModel, $settings, array $adapters = [])
    {
        $this->dataModel = $dataModel;
        $this->settings = $settings;

        $this->adapters = $this->buildAdapters($settings, $adapters);
    }

    /**
     * @return FormFieldCollection
     */
    public function createFormFieldCollection()
    {
        $this->buildFields();
        $this->applyUserOptions();
        $this->cleanUp();

        return new FormFieldCollection($this->fields);
    }


    public function setSubtraction(array $subtract)
    {
        $this->subtract = $subtract;
    }

    public function setOptions(array $options)
    {
        $this->userOptions = $options;
    }

    private function buildAdapters($settings, array $adapters = [])
    {
        $adapterFactory = new AdapterFactory();
        return $adapterFactory->createAdapters($settings, $adapters);
    }

    private function buildFields()
    {
        foreach ($this->adapters as $adapter) {
            $this->fields = array_merge($this->fields, $adapter->adapt($this->dataModel));
        }
    }

    private function applyUserOptions()
    {
        foreach ($this->userOptions as $fieldName => $option) {
            if ($this->checkIfFieldExists($fieldName)) {
                $this->fields[$fieldName] = $option->applyOption($this->fields[$fieldName]);
            } else {
                throw new \Exception('Field: ' .$fieldName .' does not exists for applying the option');
            }
        }
    }

    private function checkIfFieldExists($fieldName)
    {
        if (isset($this->fields[$fieldName]) && is_object($this->fields[$fieldName])) {
            return true;
        }

        return false;
    }

    private function cleanUp()
    {
        $this->applySubtraction();
        $this->removePrimaryIdField();
        $this->removeBlankFields();
    }

    private function applySubtraction()
    {
        foreach ($this->subtract as $subtractionField) {
            unset($this->fields[$subtractionField]);
        }
    }

    private function removePrimaryIdField()
    {
        unset($this->fields[self::STANDARD_ID_FIELD]);
    }

    private function removeBlankFields()
    {
        foreach ($this->fields as $key => $formField) {
            if (empty($formField)) {
                unset($this->fields[$key]);
            }
        }
    }


}
