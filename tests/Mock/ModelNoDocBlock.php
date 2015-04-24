<?php

namespace michaelmeelis\FormCreator\tests\Mock;

use michaelmeelis\DocBlockModelParser\Interfaces\ModelInterface;

class ModelNoDocBlock implements ModelInterface
{

    /**
     * @return string    return the name of the table that is connected with the model
     */
    public function getTable()
    {
        return 'foobar';
    }
}