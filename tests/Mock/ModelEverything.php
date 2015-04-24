<?php

namespace michaelmeelis\FormCreator\tests\Mock;

/**
 * @property integer $id
 *
 * @property string $name
 *
 * @property integer $onlyProperties_id
 * @property integer $noDocBlock_id
 * @property-read \stdClass|\michaelmeelis\DocBlockModelParser\tests\Mock\ModelOnlyProperties[] $onlyProperties
 * @property-read \michaelmeelis\DocBlockModelParser\tests\Mock\ModelNoDocBlock[] $noDocBlock
 *
 * @property integer $singleProperties_id
 * @property-read \michaelmeelis\DocBlockModelParser\tests\Mock\ModelOnlySingle $singleProperties
 **/
class ModelEverything
{
    /**
     * @var int should be skipped
     */
    public $id = 1;

    /**
     * @var string Should be visible as a property
     */
    public $name = 'everything';

    /**
     * @var int Multiple combo
     */
    public $onlyProperties_id;
    public $onlyProperties;

    /**
     * @var int Multiple combo
     */
    public $noDocBlock_id;
    public $noDocBlock;

    /**
     * @var int Single combo
     */
    public $singleProperties_id;
    public $singleProperties;
}