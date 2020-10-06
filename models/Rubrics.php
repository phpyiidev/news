<?php

namespace app\models;

use Yii;
use \app\models\base\Rubrics as BaseRubrics;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "rubrics".
 */
class Rubrics extends BaseRubrics
{

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                # custom validation rules
            ]
        );
    }

    public static function listAll($keyField = 'id', $valueField = 'name', $asArray = true)
    {
        $query = static::find();
        if ($asArray) {
            $query->select([$keyField, $valueField])->asArray();
        }

        return ArrayHelper::map($query->all(), $keyField, $valueField);
    }

    public static function listAllFormated(&$out, $id = null, &$level = 0, $type = "list")
    {
        $rubrics = static::findAll(['id_parent' => $id]);
        foreach ($rubrics as $model) {
            $prefix = "";
            for ($c=0;$c<$level;$c++) {
                $prefix .= "-";
            }
            $level++;
            static::listAllFormated($out, $model->id, $level);
            $level--;
            if ($type == "list") {
                $out[$model->id] = $prefix.$model->name;
            } elseif ($type == "array") {
                array_push($out,$model);
            }
        }
        return array_reverse($out,true);
    }

    public static function getSubRubrics($id, &$out, &$level = 0, $type = "list")
    {
        $subRubrics = static::findAll(['id_parent' => $id]);
        $prefix = "";
        $level++;
        for ($c=0;$c<=$level;$c++) {
            $prefix .= "-";
        }
        foreach ($subRubrics as $model) {
            $out = static::getSubRubrics($model->id, $subRubrics);
            if ($type == "list") {
                $allSubRubrics[$model->id] = $prefix.$model->name;
            } elseif ($type == "array") {
                array_push($allSubRubrics, $subRubrics);
            }
        }
        return $allSubRubrics;
    }
}
