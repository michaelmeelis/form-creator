<?php

namespace BeFriends\Admin\FormCreator\FormModels;

use BeFriends\Admin\FormCreator\Collections\FormFieldCollection;
use BeFriends\Admin\FormCreator\Factory\FormField\Options\BaseOption;
use BeFriends\Admin\FormCreator\Factory\FormFieldCollection\Adapters\BaseAdapter;
use BeFriends\Admin\FormCreator\Factory\FormFieldCollection\FieldCollectionFactory;

abstract class BaseFormModel
{
    /**
     * @var FormFieldCollection
     */
    protected $fields;

    protected $dataModel;

    /**
     * @var BaseOption[] array
     */
    protected $options = [];

    /**
     * @var BaseAdapter[]
     */
    protected $adapters = [];
    /**
     * @var array
     */
    protected $subtract = [];

    protected $header;
    protected $footer;
    protected $settings = [];

    protected $modelAttributeToValue = [];

    private $linkedModelName;
    private $isNew = false;

    public function __construct($dataModel = null, array $settings = [], $linkedModelName = '')
    {
        $this->linkedModelName = $linkedModelName;
        $this->settings = $this->settings + $settings;
        $this->setDataModel($dataModel);
    }

    public function isNew()
    {
        return $this->isNew;
    }

    public function build()
    {
        $this->fields = $this->buildFields();
    }

    /**
     * @return string
     */
    public function getFooter()
    {
        return $this->footer;
    }

    /**
     * @return string
     */
    public function getHeader()
    {
        return $this->header;
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


    public function setDataModel($dataModel)
    {
        if (is_null($dataModel)) {
            $this->dataModel = new $this->linkedModelName;
            $this->isNew = true;
        } else {
            $this->dataModel = $dataModel;
        }
    }

    public function getDataModel()
    {
        return $this->dataModel;
    }

    public function getLinkedModelName()
    {
        return $this->linkedModelName;
    }

    /**
     * @return FormFieldCollection
     * @throws \Exception
     */
    public function getFields()
    {
        if ($this->fields instanceof FormFieldCollection) {
            return $this->fields;
        }

        throw new \Exception(
            'Fields not build for ' . $this->getLinkedModelName() . '
            please check the dataModel or use the build function before use'
        );
    }

    /**
     * Pro tip - Use the attribute in your Form Model to set this
     *
     * @param BaseOption[] $options
     */
    public function setOptions($options)
    {
        $this->options = $this->options + $options;
    }

    /**
     * Pro tip - Use the attribute in your Form Model to set this
     *
     * @param array $subtract
     */
    public function setSubtraction(array $subtract)
    {
        $this->subtract = array_merge($this->subtract, $subtract);
    }

    protected function buildFields()
    {
        if (!empty($this->dataModel)) {
            $collectionFactory = new FieldCollectionFactory($this->dataModel, $this->settings, $this->adapters);
            $collectionFactory->setOptions($this->options);
            $collectionFactory->setSubtraction($this->subtract);

            return $collectionFactory->createFormFieldCollection();
        }

        throw new \Exception('No data model found for ' .$this->linkedModelName);
    }
}
