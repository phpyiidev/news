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
        if (!empty($filter)) {
            $query->andWhere($filter);
        }
        if (isset($requestParams['id_parents'])) {
            $rubrics = [];
            if (!is_array($requestParams['id_parents'])) {
                $id_parents = explode(",", $requestParams['id_parents']);
            } else {
                $id_parents = $requestParams['id_parents'];
            }
            foreach ($id_parents as $id_parent) {
                $rubrics += Rubrics::getSubRubrics($id_parent,$rubrics);
            }
            var_dump($rubrics);
            $query->andFilterWhere(['in', 'id', $rubrics]);
        }

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
