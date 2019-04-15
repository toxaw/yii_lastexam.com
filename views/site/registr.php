<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Users;

$this->title = 'Регистрация';
?>
<div class="site-signup">
    <div class="row">
        <div class="col-md-6">

            <h1>Введите ваши учетные данные</h1>
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

            <?= $form->field($model, 'fio')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'login') ?>

            <?= $form->field($model, 'email') ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'repeatPassword')->passwordInput() ?>
            
            <?= $form->field($model, 'agree')->checkbox([
            'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
            ]) ?>

            <div class="form-group">
                <?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>