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

    public static function getSubRubricsArray() {
        $rubrics = static::find()->all();
        if (empty($rubrics)) {
            return null;
        }
        $subRubricsArr = [];
        /** @var Rubrics[] $rubrics */
        foreach ($rubrics as $rubric) {
            $id_parent = is_null($rubric->id_parent) ? 0 : $rubric->id_parent;
            if (empty($subRubricsArr[$id_parent])) {
                $subRubricsArr[$id_parent] = [];
            }
            $subRubricsArr[$id_parent][] = $rubric;
        }
        return $subRubricsArr;
    }

    public static function getRubricsTree($subRubricsArr, &$out, $id_parent = 0)
    {
        if (empty($subRubricsArr[$id_parent])) {
            return $out;
        }
        /** @var Rubrics $rubric */
        foreach ($subRubricsArr[$id_parent] as $rubric) {
            $items[$rubric->id] = [
                'id' => $rubric->id,
                'name' => $rubric->name,
                'id_parent' => $rubric->id_parent,
                'items' => []
            ];
            self::getRubricsTree($subRubricsArr, $items, $rubric->id);
            $out[$id_parent]['items'] = $items;
        }
        return $out;
    }

    public static function listAllFormated(&$out, $id = null, &$level = 0, $type = "list")
    {
        $rubrics = static::findAll(['id_parent' => $id]);
        foreach ($rubrics as $model) {
            $prefix = "";
            for ($c=0;$c<$level;$c++) {
                $prefix .= "- ";
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

    public static function getSubRubrics($id, &$out)
    {
        $subRubrics = static::findAll(['id_parent' => $id]);
        foreach ($subRubrics as $model) {
            static::getSubRubrics($model->id, $subRubrics);
        }
        array_push($out,[$model->id => $model->name]);
        //array_push($out, $result);
        print_r($out);exit;
        return $out;
    }
}
