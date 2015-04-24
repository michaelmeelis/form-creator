<?php

namespace michaelmeelis\FormCreator\tests\Mock;

use michaelmeelis\DocBlockModelParser\Interfaces\ModelInterface;

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
    public $id = 1;
    public $name = 'name property';

    /**
     * @return string    return the name of the table that is connected with the model
     */
    public function getTable()
    {
        return 'foobar';
    }
}