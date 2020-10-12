<?php

namespace app\controllers\api;
/**
 * REST контроллер новостей. По запросу возвращает список новостей в json формате. Единственное действие "index"
 * принимает GET параметр "rubrics" - массив идентификаторов рубрик, по которому возвращает список новостей для всех
 * указанных рубрик и их подрубрик по все уровням.
 */

use app\models\News;
use app\models\Rubrics;
use Yii;

class NewsController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\News';

    public function actions()
    {
        $actions = parent::actions();

        // отключить действия все действия, кроме "index"
        unset($actions['delete'], $actions['create'], $actions['update'], $actions['view']);

        // замена провайдера данных для действия "index" с помощью метода "prepareDataProvider()"
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    public function prepareDataProvider()
    {
        // Можно реализовать через dataProvider, для использования сортировки, фильтров и пагинации. Т.к. в задании
        // не указан данный функционал, был выбран простоя метод возврата данных.
        $id_rubrics = [];
        $subRubricsId = Rubrics::getSubrubricsId($id_rubrics, Yii::$app->request->get("rubrics"));
        $news = News::find()->joinWith(['rubrics'])->where(['in', 'news_rubrics.id_rubric', $subRubricsId])->all();
        return $news;
    }
}
