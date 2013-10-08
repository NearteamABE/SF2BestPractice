<?php

namespace Nearteam\Core\Component\Exception;

class InvalidArgumentException extends \Exception
{

    private $fieldName;
    private $fieldValue;
    private $performedCheck;
    private $performedCheckParameters;
    private $errors;

    function __construct($fieldName = null, $fieldValue = null, $performedCheck = null, $performedCheckParameters = null, $errors = null)
    {
        $errorMessage = "field ";
        if (!empty($fieldName)) {
            $errorMessage.= "'" . $fieldName . "' ";
        }
        if (!empty($fieldValue)) {
            $errorMessage.= '= ' . var_export($fieldValue, true) . ' ';
        }
        $errorMessage.= "did not meet requirement ";

        if (!empty($performedCheck)) {
            $errorMessage.= "'$performedCheck'";

            if (!empty($performedCheckParameters)) {
                $errorMessage.= ' (' . var_export($performedCheckParameters, true) . ')';
            }
        }

        if (!empty($errors)) {
            $errorMessage.= ', errors : ' . var_export($errors, true);
        }

        parent::__construct($errorMessage);

        $this->fieldName = $fieldName;
        $this->fieldValue = $fieldValue;
        $this->performedCheck = $performedCheck;
        $this->performedCheckParameters = $performedCheckParameters;
        $this->errors = $errors;
    }

    public function getFieldName()
    {
        return $this->fieldName;
    }

    public function getFieldValue()
    {
        return $this->fieldValue;
    }

    public function getPerformedCheck()
    {
        return $this->performedCheck;
    }

    public function getPerformedCheckParameters()
    {
        return $this->performedCheckParameters;
    }

    public function getErrors()
    {
        return $this->errors;
    }

}
