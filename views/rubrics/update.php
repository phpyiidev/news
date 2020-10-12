<?php

use yii\helpers\Html;

/**
 * Представление редактирование рубрики
 * @var yii\web\View $this
 * @var app\models\Rubrics $model
 * @var string $relAttributes relation fields names for disabling
 */
if (!isset($relAttributes)) {
    $relAttributes = false;
}

$this->title = 'Рубрика ' . $model->name . ', ' . 'Редактирование';
$this->params['breadcrumbs'][] = ['label' => 'Рубрики', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="giiant-crud rubrics-update">

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-eye-open"></span> ' . 'Просмотр', ['view', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr/>

    <?php echo $this->render('_form', [
        'model' => $model,
        'relAttributes' => $relAttributes,
    ]); ?>

</div>
