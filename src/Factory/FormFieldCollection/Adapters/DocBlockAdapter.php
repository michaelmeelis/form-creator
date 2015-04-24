<?php
namespace michaelmeelis\FormCreator\Factory\FormFieldCollection\Adapters;

use michaelmeelis\FormCreator\Models\FormField;
use michaelmeelis\DocBlockModelParser\Factory\PropertyFactory;
use phpDocumentor\Reflection\DocBlock;

class DocBlockAdapter extends BaseAdapter
{
    /**
     * @var \ReflectionClass
     */
    protected $reflection;

    protected $docBlock;

    protected $model;

    /**
     * @param $dataModel
     * @return FormField[]
     */
    public function adapt($dataModel)
    {
        $factory = new PropertyFactory();
        $properties = $factory->buildNormalProperties($dataModel);
        $options = $this->createOptions();
        $fields = [];
        foreach ($properties as $property) {
            $fields[$property->name] = $this->createFormField($property->name, $dataModel->{$property->name}, $options);
        }

        return $fields;
    }
}