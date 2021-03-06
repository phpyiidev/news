<?php

use app\models\Rubrics;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
 * Вывод списка всех новостей в таблице с пагинацией, возможностью фильтрации и сортировки
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\search\NewsSearch $searchModel
 */


if (isset($actionColumnTemplates)) {
    $actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
    Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'Создать', ['create'], ['class' => 'btn btn-success']);
    $actionColumnTemplateString = "{view} {update} {delete}";
}
$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud news-index">

    <?php \yii\widgets\Pjax::begin(['id' => 'pjax-main', 'enableReplaceState' => false, 'linkSelector' => '#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success' => 'function(){alert("yo")}']]) ?>
    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'Создать', ['create'], ['class' => 'btn btn-success']) ?>
        </div>

        <div class="pull-right">
            <?=
            \yii\bootstrap\ButtonDropdown::widget(
                [
                    'id' => 'giiant-relations',
                    'encodeLabel' => false,
                    'label' => '<span class="glyphicon glyphicon-paperclip"></span> ' . 'Связи',
                    'dropdown' => [
                        'options' => [
                            'class' => 'dropdown-menu-right'
                        ],
                        'encodeLabels' => false,
                        'items' => [[
                            'url' => ['rubrics/index'],
                            'label' => '<i class="glyphicon glyphicon-arrow-right">&nbsp;' . 'Рубрики' . '</i>',
                        ],]
                    ],
                    'options' => [
                        'class' => 'btn-default'
                    ]
                ]
            );
            ?>
        </div>
    </div>

    <hr/>

    <div class="table-responsive">
        <?= GridView::widget([
            'layout' => '{summary}{pager}{items}{pager}',
            'dataProvider' => $dataProvider,
            'pager' => [
                'class' => yii\widgets\LinkPager::className(),
                'firstPageLabel' => 'First',
                'lastPageLabel' => 'Last'],
            'filterModel' => $searchModel,
            'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
            'headerRowOptions' => ['class' => 'x'],
            'columns' => [

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => $actionColumnTemplateString,
                    'urlCreator' => function ($action, $model, $key, $index) {
                        // using the column name as key, not mapping to 'id' like the standard generator
                        $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string)$key];
                        $params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id . '/' . $action : $action;
                        return Url::toRoute($params);
                    },
                    'contentOptions' => ['width' => '4%', 'nowrap' => 'nowrap'],
                ],
                [
                    'class' => 'yii\grid\SerialColumn',
                    'contentOptions' => ['width' => '2%', 'nowrap' => 'nowrap'],
                ],
                [
                    'attribute' => 'name',
                    'width' => '20%',
                ],
                [
                    'attribute' => 'text',
                    'width' => '60%',
                ],
                [
                    'attribute' => 'rubrics',
                    'format' => 'row',
                    'content' => function ($model) {
                        $arrNameRubrics = ArrayHelper::getColumn($model->rubrics, 'name');
                        return empty($arrNameRubrics) ? '' : implode(", ", $arrNameRubrics);
                    },
                    'filter' => Select2::widget([
                        'id' => 'grid-rubrics-filter',
                        'model' => $searchModel,
                        'attribute' => 'rubrics',
                        'data' => ArrayHelper::map(Rubrics::find()->all(), 'id', 'name'),
                        'options' => [
                            'placeholder' => 'Фильтр по рубрикам...',
                            'multiple' => true
                        ],
                        'pluginOptions' => [
                            'tags' => true,
                            'tokenSeparators' => [',', ' '],
                            'maximumInputLength' => 10
                        ],
                    ]),
                ],
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


