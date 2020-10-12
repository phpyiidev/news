<?php

namespace app\controllers\api;

/**
 * REST контроллер рубрик. По запросу возвращает все рубрики и их подрубрики в виде дерева в json формате. Единственное
 * действие "index" без параметров - возвращает все рубрики и подрубрики в виде дерева.
 */

use app\models\Rubrics;

class RubricsController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\Rubrics';

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
        $rubrics['items'] = [];
        $subRubricsArr = Rubrics::getSubRubricsArray();
        return Rubrics::getRubricsTree($subRubricsArr, $rubrics, 0);
    }
}
