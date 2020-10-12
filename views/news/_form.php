<?php

use kartik\widgets\Select2;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\StringHelper;

/**
 * Форма для создания/редактирования новостей
 * @var yii\web\View $this
 * @var app\models\News $model
 * @var yii\widgets\ActiveForm $form
 * @var string $relAttributes relation fields names for disabling
 */

$listRubrics = [];
?>

<div class="news-form">

    <?php $form = ActiveForm::begin([
            'id' => 'News',
            'enableClientValidation' => true,
            'errorSummaryCssClass' => 'error-summary alert alert-error'
        ]
    );
    ?>

    <div class="">
        <p>
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'text')->textarea(['rows' => 5]) ?>
            <?= $form->field($model, 'rubrics')->widget(Select2::classname(), [
                'data' => \app\models\Rubrics::listAllFormatted($listRubrics),
                'options' => ['placeholder' => 'Выберите рубрики ...', 'multiple' => true],
                'pluginOptions' => [
                    'tags' => true,
                    'tokenSeparators' => [',', ' '],
                    'maximumInputLength' => 10
                ],
            ])->label('Рубрики'); ?>
        </p>

        <hr/>

        <?php echo $form->errorSummary($model); ?>

        <?= Html::submitButton(
            '<span class="glyphicon glyphicon-check"></span> ' .
            ($model->isNewRecord ? 'Создать' : 'Сохранить'),
            [
                'id' => 'save-' . $model->formName(),
                'class' => 'btn btn-success'
            ]
        );
        ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>

