<?php

namespace BeFriends\Admin\FormCreator\Factory\FormFieldCollection\Adapters;

use BeFriends\Admin\FormCreator\Factory\FormField\Options\ModelOption;
use BeFriends\Admin\FormCreator\Factory\FormField\Options\ModelSelectionOption;
use BeFriends\Admin\FormCreator\Factory\FormField\Options\RelatedTableOption;
use michaelmeelis\DocBlockModelParser\Collections\PropertyCollection;
use michaelmeelis\DocBlockModelParser\Factory\PropertyFactory;
use phpDocumentor\Reflection\DocBlock;

class DocBlockModelAdapter extends BaseAdapter
{
    protected $idFieldNamePostFix;
    protected $readProperties;


    public function adapt($dataModel)
    {
        $propertyFactory = new PropertyFactory();
        $this->model = $dataModel;

        $singleProperties = $propertyFactory->buildSingleProperties($dataModel);
        $multipleProperties = $propertyFactory->buildMultipleProperties($dataModel);

        $properties = $this->createFields($singleProperties) + $this->createFields($multipleProperties);

        return $properties;
    }

    protected function createFields(PropertyCollection $properties)
    {
        $fields = [];
        foreach ($properties as $property) {
            $fieldName = $property->name . $this->idFieldNamePostFix;
            $fieldValue = $this->model->{$fieldName};
            $options = $this->createOptions($property->modelClassName);
            $fields[$fieldName] = $this->formFieldFactory->createFormField($fieldName, $fieldValue, $options);
        }
        return $fields;
    }

    /**
     * @todo get options from settings too.
     * @param string $className
     * @return array
     */
    protected function createOptions($className = '')
    {
        $options = array_merge($this->createDefaultOptions($className), $this->createSettingsOptions());

        return $options;
    }

    protected function createDefaultOptions($className = '')
    {
        $options[] = new ModelOption($this->settings, $className);
        $options[] = new ModelSelectionOption($this->settings);
        $options[] = new RelatedTableOption($this->settings);

        return $options;
    }
}
