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
}
