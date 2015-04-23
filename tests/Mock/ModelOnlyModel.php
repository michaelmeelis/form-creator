<?php

namespace michaelmeelis\FormCreator\tests\Mock;

use michaelmeelis\DocBlockModelParser\Interfaces\ModelInterface;

/**
 * @property integer $onlyProperties_id
 * @property integer $noDocBlock_id
 * @property-read \stdClass|\michaelmeelis\DocBlockModelParser\tests\Mock\ModelOnlyProperties[] $onlyProperties
 * @property-read \michaelmeelis\DocBlockModelParser\tests\Mock\ModelNoDocBlock[] $noDocBlock
 **/

class ModelOnlyModel implements ModelInterface
{

    /**
     * @return string    return the name of the table that is connected with the model
     */
    public function getTable()
    {
        return 'foobar';
    }
}