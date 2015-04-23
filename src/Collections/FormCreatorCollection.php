<?php

namespace BeFriends\Admin\FormCreator\Collections;


use BeFriends\Admin\FormCreator\FormCreator;

class FormCreatorCollection extends BaseCollection
{
    /**
     * @var FormCreator[]
     */
    protected $collection;

    /**
     * @param FormCreator[] $collection
     */
    public function __construct($collection = [])
    {
        parent::__construct($collection);
    }

    public function merge(FormCreatorCollection $collection)
    {
        $mergeCollection = $collection->getCollection();
        $this->collection = array_merge($mergeCollection, $this->collection);
    }

    public function applyOrder($order)
    {
        $temp = [];

        foreach ($order as $keyName) {
            foreach ($this->collection as $formCreator) {
                if ($formCreator->getModelName() == $keyName) {
                    $temp[] = $formCreator;
                    break;
                }
            }
        }

        $this->collection = $temp;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param FormCreator $value <p>
     * The value to set.
     * </p>
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (!$value instanceof FormCreator) {
            throw new \BadMethodCallException('Value must be a Form Creator object');
        }

        if (empty($offset)) {
            $this->collection[] = $value;
        } else {
            $this->collection[$offset] = $value;
        }

    }
}
