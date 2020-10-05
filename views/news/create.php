<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\News $model
 * @var string $relAttributes relation fields names for disabling
 */
if (!isset($relAttributes)) {
    $relAttributes = false;
}

$this->title = 'Создать';
$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud news-create">

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
