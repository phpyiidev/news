<?php

use dmstr\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\detail\DetailView;

/**
 * Представление просмотра новости
 * @var yii\web\View $this
 * @var app\models\News $model
 */
$copyParams = $model->attributes;

$this->title = "Новость \"" . $model->name . "\"";
$this->params['breadcrumbs'][] = ['label' => "Новости", 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Просмотр';
?>
<div class="giiant-crud news-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
                '<span class="glyphicon glyphicon-pencil"></span> ' . 'Редактировать',
                ['update', 'id' => $model->id],
                ['class' => 'btn btn-info']) ?>

            <?= Html::a(
                '<span class="glyphicon glyphicon-copy"></span> ' . 'Копировать',
                ['create', 'id' => $model->id, 'News' => $copyParams],
                ['class' => 'btn btn-success']) ?>

            <?= Html::a(
                '<span class="glyphicon glyphicon-plus"></span> ' . 'Новая новость',
                ['create'],
                ['class' => 'btn btn-success']) ?>
        </div>

        <div class="pull-right">
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> '
                . 'Список новостей', ['index'], ['class' => 'btn btn-default']) ?>
        </div>

    </div>

    <hr/>

    <?php $this->beginBlock('app\models\News'); ?>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'text',
            [
                'attribute' => 'rubrics',
                'label' => 'Рубрики',
                'format' => 'html',
                'value' => function (\kartik\form\ActiveForm $form, kartik\detail\DetailView $detailView) {
                    $arrNameRubrics = ArrayHelper::getColumn($detailView->model->rubrics, 'name');
                    return empty($arrNameRubrics) ? '' : implode(", ", $arrNameRubrics);
                },
            ],
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
        ],
    ]); ?>


    <hr/>

    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . 'Удалить', ['delete', 'id' => $model->id],
        [
            'class' => 'btn btn-danger',
            'data-confirm' => '' . 'Вы действительно хотите удалить эту новость?' . '',
            'data-method' => 'post',
        ]); ?>
    <?php $this->endBlock(); ?>


    <div class="row">
        <div class="col-md-4">
            <?= $this->blocks['app\models\News'] ?>
        </div>
    </div>
</div>
