<?php

namespace logvin\behaviors;

use yii\base\Behavior;
use yii\rest\Serializer;

class RelationExpandFields extends Behavior
{
    protected $_expandName;

    public function getNewFields()
    {

        $fields = [];
        $serializer = new Serializer();
        $expandRequest = $serializer->request->get($serializer->expandParam);
        $expand = preg_split('/\s*,\s*/', $expandRequest, -1, PREG_SPLIT_NO_EMPTY);

        if (empty($expand)) {
            return [];
        }

        foreach ($expand as $expandField) {
            $expandName = strstr($expandField, ':', true);
            if ($expandName) {
                $expandFields = explode('|', substr(strrchr($expandField, ":"), 1));
                foreach ($expandFields as $expandField) {
                    if (in_array($expandField, $this->owner->extraFields()) && $expandName == $this->expandName) {
                        $fields[$expandField] = $expandField;
                    }
                }
            } else {
                if (in_array($expandField, $this->owner->extraFields())) {
                    $fields[$expandField] = $expandField;
                }
            }
        }

        return $fields;
    }

    public function getExpandName()
    {
        $value = $this->_expandName !== null ? $this->_expandName : end(explode("\\", $this->owner->className()));
        return $value;
    }

    public function setExpandName($value)
    {
        $this->_expandName = $value;
    }
}
