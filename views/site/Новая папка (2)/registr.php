<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Users;

$this->title = 'Регистрация';
?>
<div class="site-signup">
    <div class="row">
        <div class="col-md-6">

            <p>Введите ваши учетные данные:</p>
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

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'firstname') ?>

            <?= $form->field($model, 'lastname') ?>

            <?= $form->field($model, 'middlename') ?>

            <?= $form->field($model, 'email') ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'password_repeat')->passwordInput() ?>

            <div class="form-group">
                <?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>