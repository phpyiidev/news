<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\StringHelper;

/**
 * @var yii\web\View $this
 * @var app\models\News $model
 * @var yii\widgets\ActiveForm $form
 * @var string $relAttributes relation fields names for disabling
 */

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
            <? print_r(\app\models\Rubrics::listAllFormated());exit; ?>
            <?= $form->field($model, 'rubrics')->dropDownList(\app\models\Rubrics::listAllFormated(), []) ?>
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

