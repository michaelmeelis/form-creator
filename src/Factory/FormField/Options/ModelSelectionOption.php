<?php

namespace BeFriends\Admin\FormCreator\Factory\FormField\Options;

use BeFriends\Admin\FormCreator\Models\FormField;
use BeFriends\Admin\FormCreator\Models\SelectFormField;

class ModelSelectionOption extends BaseOption
{
    private $skipModels = [
        'Carbon\Carbon'
    ];

    /**
     * @param FormField $formField
     * @return SelectFormField
     */
    public function applyOption(FormField $formField)
    {
        if ($this->checkIfModelPresent($formField)) {
            $formField->selection = $this->getSelectionData($formField);
        }

        return $formField;
    }

    private function getSelectionData($formField)
    {
        $selection = [];
        $fieldName = $this->getTranslationFieldName($formField);
        $class = get_class($formField->model);
        foreach ($class::all() as $selectionModel) {
            $selection[$selectionModel->id] = $selectionModel->{$fieldName};
        }
        return $selection;
    }

    private function getTranslationFieldName($formField)
    {
        return $this->localSettings[$formField->name];
    }

    private function checkIfModelPresent(FormField $formField)
    {
        if (is_object($formField->model)) {
            $formFieldModelClass = get_class($formField->model);

            return !in_array($formFieldModelClass, $this->skipModels);
        }

        \Log::error('Model not found but selection option called');

        return false;
    }
}