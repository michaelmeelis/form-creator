<?php

namespace michaelmeelis\FormCreator\tests\FormFieldCollection\Adapters;

use michaelmeelis\FormCreator\Factory\FormFieldCollection\Adapters\DocBlockAdapter;
use michaelmeelis\FormCreator\tests\Mock\ModelEverything;
use michaelmeelis\FormCreator\tests\Mock\ModelOnlyModel;
use michaelmeelis\FormCreator\tests\Mock\ModelOnlyProperties;
use michaelmeelis\FormCreator\tests\Mock\ModelOnlySingle;

class DocBlockAdapterTest extends \PHPUnit_Framework_TestCase
{

    public function testAdaptWithoutSettingWithModelContainingModels()
    {
        $model = new ModelOnlyModel();
        $adapter = new DocBlockAdapter([]);
        $formFields = $adapter->adapt($model);

        $this->assertCount(0, $formFields);

    }

    public function testAdaptWithoutSettingWithModelOnlyProperties()
    {
        $model = new ModelOnlyProperties();
        $adapter = new DocBlockAdapter([]);
        $formFields = $adapter->adapt($model);

        $this->assertInstanceOf('michaelmeelis\FormCreator\Models\FormField', $formFields['name']);
    }

    public function testAdaptWithoutSettingsWithModelOnlySingle()
    {
        $model = new ModelOnlySingle();
        $adapter = new DocBlockAdapter([]);
        $formFields = $adapter->adapt($model);
    }

    public function testAdaptWithoutSettingsWithModelEverything()
    {
        $model = new ModelEverything();
        $adapter = new DocBlockAdapter([]);
        $formFields = $adapter->adapt($model);
    }

}
