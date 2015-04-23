<?php

namespace BeFriends\Admin\FormCreator\FormModels;


interface FormModelInterface {

    /**
     * @param string $table
     * @return object|\IteratorAggregate
     */
    public function getDataRelation($table);

    /**
     * @return string name of the table
     */
    public function getTable();

}