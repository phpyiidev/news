<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "NewsController".
*/

use app\models\News;
use app\models\Rubrics;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use function igorw\retry;

class NewsController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\News';

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
        $id_rubrics = [];
        $subRubricsId = Rubrics::getSubrubricsId($id_rubrics,Yii::$app->request->get("rubrics"));
        $news = News::find()->joinWith(['rubrics'])->where(['in', 'news_rubrics.id_rubric', $subRubricsId])->all();
        return $news;
    }
}
