<?php

namespace michaelmeelis\FormCreator\tests\Mock;

use michaelmeelis\FormCreator\Interfaces\ModelInterface;

/**
 * Class ModelOnlyProperties
 *
 * This will assert to a count of 1 with normal properties.
 * Id is left out because it is reserved
 *
 * @package michaelmeelis\DocBlockModelParser\test\Mock
 * @property integer $id
 * @property string $name
 *
 */
class ModelOnlyProperties implements ModelInterface
{

    /**
     * @return string    return the name of the table that is connected with the model
     */
    public function getTable()
    {
        return 'foobar';
    }
}