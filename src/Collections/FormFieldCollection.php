<?php
namespace michaelmeelis\FormCreator\Collections;

use michaelmeelis\FormCreator\Models\FormField;


class FormFieldCollection extends BaseCollection
{
    /**
     * @param FormField[] $collection
     */
    public function __construct($collection = [])
    {
        parent::__construct($collection);
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            throw new \BadMethodCallException('Key must be used with the Collection');
        }

        if ($value instanceof FormField) {
            throw new \BadMethodCallException('Value must be a form field');
        }

        $this->collection[$offset] = $value;
    }

}