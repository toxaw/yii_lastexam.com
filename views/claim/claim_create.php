<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Users;

$this->title = 'Изменение статуса';
?>
<div class="site-signup">
    <div class="row">
        <div class="col-md-6">

            <h1>Cоздать заявку</h1>
            <?php
            $form = ActiveForm::begin([
                        'layout' => 'horizontal',
                        'enableAjaxValidation' => true,
                        'fieldConfig' => [
                            'template' => '{label}<div>{input}</div><div>{error}</div>',
                            'labelOptions' => ['class' => 'control-label'],
                        ],
            ]);
            ?>

            <?= $form->field($model, 'title')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'description')->textArea() ?>
            
            <?= $form->field($model, 'category_id')->dropDownList($categories) ?>

            <?= $form->field($model, 'photo')->fileInput() ?>
            
            <div class="form-group">
                <?= Html::submitButton('Создать заявку', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>