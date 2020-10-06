<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "NewsController".
*/

use app\models\Rubrics;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class NewsController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\News';

    public function actions()
    {
        $actions = parent::actions();

        // отключить действия "delete" и "create"
        //unset($actions['delete'], $actions['create']);

        // настроить подготовку провайдера данных с помощью метода "prepareDataProvider()"
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    public function prepareDataProvider()
    {
        $requestParams = Yii::$app->getRequest()->getBodyParams();
        if (empty($requestParams)) {
            $requestParams = Yii::$app->getRequest()->getQueryParams();
        }

        /* @var $modelClass \yii\db\BaseActiveRecord */
        $modelClass = $this->modelClass;

        $query = $modelClass::find();
        $query->joinWith(['rubrics']);
        if (!empty($filter)) {
            $query->andWhere($filter);
        }
        $rubrics = Rubrics::findAll(['in']);
        $query->andFilterWhere(['in', 'news_rubrics.id_rubric', $requestParams['rubrics']]);

        return Yii::createObject([
            'class' => ActiveDataProvider::className(),
            'query' => $query,
            'pagination' => [
                'params' => $requestParams,
            ],
            'sort' => [
                'params' => $requestParams,
            ],
        ]);
    }
}
