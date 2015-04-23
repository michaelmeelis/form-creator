<?php

namespace michaelmeelis\FormCreator\tests\Mock;

use michaelmeelis\FormCreator\Interfaces\ModelInterface;

/**
 * Class ModelOnlySingle
 * @package michaelmeelis\DocBlockModelParser\test\Mock
 * @property integer $onlyProperties_id
 * @property integer $noDocBlock_id
 * @property-read \michaelmeelis\DocBlockModelParser\tests\Mock\ModelOnlyProperties $onlyProperties
 * @property-read \michaelmeelis\DocBlockModelParser\tests\Mock\ModelNoDocBlock $noDocBlock
 *
 */
class ModelOnlySingle implements ModelInterface
{

    /**
     * @return string    return the name of the table that is connected with the model
     */
    public function getTable()
    {
        return 'foobar';
    }
}