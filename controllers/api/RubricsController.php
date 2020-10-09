<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "RubricsController".
*/

use app\models\Rubrics;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class RubricsController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\Rubrics';

    public function actions()
    {
        $actions = parent::actions();

        // отключить действия "delete" и "create"
        unset($actions['delete'], $actions['create'], $actions['update'], $actions['view']);

        // настроить подготовку провайдера данных с помощью метода "prepareDataProvider()"
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    public function prepareDataProvider()
    {
        $rubrics['items'] = [];
        $subRubricsArr = Rubrics::getSubRubricsArray();
        $firstRubric = Rubrics::find()->orderBy(['id' => 'DESC'])->one();
        return Rubrics::getRubricsTree($subRubricsArr, $rubrics, 0);
    }
}
