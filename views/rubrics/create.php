<?php

use yii\helpers\Html;

/**
 * Представление создания рубрики
 * @var yii\web\View $this
 * @var app\models\Rubrics $model
 * @var string $relAttributes relation fields names for disabling
 */
if (!isset($relAttributes)) {
    $relAttributes = false;
}

$this->title = 'Добавить рубрику';
$this->params['breadcrumbs'][] = ['label' => 'Рубрика', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud rubrics-create">

    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?= Html::a(
                'Назад',
                \yii\helpers\Url::previous(),
                ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <hr/>

    <?= $this->render('_form', [
        'model' => $model,
        'relAttributes' => $relAttributes,
    ]); ?>

</div>
