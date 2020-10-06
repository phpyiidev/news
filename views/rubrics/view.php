<?php

use dmstr\helpers\Html;
use kartik\detail\DetailView;


/**
 * @var yii\web\View $this
 * @var app\models\Rubrics $model
 */
$copyParams = $model->attributes;

$this->title = "Рубрика " . $model->name;
$this->params['breadcrumbs'][] = ['label' => "Рубрики", 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Просмотр';
?>
<div class="giiant-crud rubrics-view">

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
                '<span class="glyphicon glyphicon-plus"></span> ' . 'Добавить подрубрику',
                ['create', 'id_parent' => $model->id],
                ['class' => 'btn btn-success']) ?>
        </div>

        <div class="pull-right">
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> '
                . 'Список рубрик', ['index'], ['class' => 'btn btn-default']) ?>
        </div>

    </div>

    <hr/>

    <?php $this->beginBlock('app\models\Rubrics'); ?>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            [
                'attribute' => 'id_parent',
                'label' => 'Родительская рубрика',
                'format' => 'html',
                'value' => function (\kartik\form\ActiveForm $form, kartik\detail\DetailView $detailView) {
                    if ($rel = $detailView->model->parent) {
                        return Html::a($rel->name, ['rubrics/view', 'id' => $rel->id,], ['data-pjax' => 0]);
                    } else {
                        return '';
                    }
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
            'data-confirm' => '' . 'Вы действительно хотите удалить эту рубрику?' . '',
            'data-method' => 'post',
        ]); ?>
    <?php $this->endBlock(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $this->blocks['app\models\Rubrics'] ?>
        </div>
        <div class="col-md-6">

        </div>
    </div>
</div>
